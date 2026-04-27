<?php

namespace App\Http\Controllers;

use App\Models\PositioningGeneration;
use App\Models\ToolUsage;
use App\Services\DynamicAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PositionnementController extends Controller
{
    private DynamicAIService $aiService;

    public function __construct(DynamicAIService $aiService)
    {
        Log::info('[POSITIONNEMENT] Controller instancié');
        $this->aiService = $aiService;
    }

    public function index()
    {
        return view('positionnement.index');
    }

    public function generer(Request $request)
    {
        // LOG 2 — La requête arrive bien
        Log::info('[POSITIONNEMENT] generer() appelé', [
            'ip'     => $request->ip(),
            'method' => $request->method(),
            'body'   => $request->all(),
        ]);

        // LOG 3 — Avant validation
        Log::info('[POSITIONNEMENT] Début validation');

        try {
            $validated = $request->validate([
                'metier'   => 'required|string|max:120',
                'techno'   => 'nullable|string|max:300',
                'niveau'   => 'nullable|string|max:60',
                'cible'    => 'required|string|max:200',
                'resultat' => 'required|string|max:500',
                'approche' => 'nullable|string|max:200',
                'extra'    => 'nullable|string|max:400',
                'usages'   => 'nullable|string|max:300',
                'ton'      => 'nullable|string|max:80',
                'longueur' => 'nullable|integer|min:1|max:3',
                'regen'    => 'nullable|boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('[POSITIONNEMENT] ❌ Validation échouée', ['errors' => $e->errors()]);
            return response()->json(['error' => 'Validation échouée', 'details' => $e->errors()], 422);
        }

        // LOG 4 — Validation OK
        Log::info('[POSITIONNEMENT] ✅ Validation OK', ['validated' => $validated]);

        $longueurMap = [
            1 => 'très courte et percutante (10 à 18 mots maximum)',
            2 => 'équilibrée (entre 20 et 30 mots)',
            3 => 'détaillée et complète (entre 30 et 45 mots)',
        ];

        $longueur = $longueurMap[$request->input('longueur', 2)];
        $ton      = $request->input('ton', 'professionnel et direct');
        $usages   = $request->input('usages', 'LinkedIn');
        $isRegen  = $request->boolean('regen');

        // LOG 5 — Avant ToolUsage
        Log::info('[POSITIONNEMENT] Tentative ToolUsage::create');

        try {
            ToolUsage::create([
                'tool_slug'  => 'positionnement',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            Log::info('[POSITIONNEMENT] ✅ ToolUsage créé');
        } catch (\Exception $e) {
            Log::error('[POSITIONNEMENT] ❌ ToolUsage::create échoué — table manquante ?', [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
            ]);
            // Non bloquant : on continue quand même
        }

        $prompt = <<<PROMPT
Tu es un expert en personal branding pour les professionnels du numérique en Afrique et dans la diaspora.

PROFIL DE L'APPRENANT :
- Métier / compétence principale : {$request->metier}
{$this->line('Niveau', $request->niveau)}
{$this->line('Technologies & outils', $request->techno)}
- Public cible : {$request->cible}
- Résultat concret apporté : {$request->resultat}
{$this->line('Approche / angle distinctif', $request->approche)}
{$this->line('Informations complémentaires', $request->extra)}
- Usages prévus : {$usages}
- Ton souhaité : {$ton}
- Longueur visée : {$longueur}
{$this->regenLine($isRegen)}

MISSION : Génère 3 phrases de positionnement professionnel distinctes, percutantes, mémorables.

FORMAT OBLIGATOIRE pour chaque phrase :
« Je [verbe d'action fort + ce que tu fais précisément] pour [public cible qualifié] [résultat tangible ou bénéfice]. »

RÈGLES STRICTES :
- Commence chaque phrase par "Je " (majuscule)
- Verbes d'action puissants et variés
- Les 3 phrases doivent être significativement différentes
- Longueur : {$longueur}
- Ton : {$ton}

Réponds UNIQUEMENT avec un objet JSON valide. Pas de texte avant ou après. Pas de backtick. Pas de markdown :
{"p1":"...","p2":"...","p3":"...","tip_linkedin":"...","tip_portfolio":"...","tip_freelance":"...","tip_candidature":"..."}
PROMPT;

        // LOG 7 — Avant appel IA
        Log::info('[POSITIONNEMENT] Appel DynamicAIService::generateText', [
            'isRegen'     => $isRegen,
            'temperature' => $isRegen ? 0.9 : 0.75,
            'prompt_len'  => strlen($prompt),
        ]);

        try {
            $aiResponse = $this->aiService->generateText($prompt, [
                'temperature' => $isRegen ? 0.9 : 0.75,
                'max_tokens'  => 1024,
            ]);

            // LOG 8 — Réponse brute IA
            Log::info('[POSITIONNEMENT] Réponse IA reçue', [
                'success'  => $aiResponse['success'] ?? null,
                'provider' => $aiResponse['provider'] ?? 'unknown',
                'error'    => $aiResponse['error'] ?? null,
                'data'     => $aiResponse['data'] ?? null,
            ]);

            if (!$aiResponse['success']) {
                Log::error('[POSITIONNEMENT] ❌ IA retourne success=false', ['error' => $aiResponse['error']]);
                return response()->json(['error' => $aiResponse['error']], 502);
            }

            $parsed   = $aiResponse['data'];
            $provider = $aiResponse['provider'] ?? 'unknown';

            // LOG 9 — Données parsées
            Log::info('[POSITIONNEMENT] Données parsées', [
                'p1_exists' => !empty($parsed['p1']),
                'p2_exists' => !empty($parsed['p2']),
                'p3_exists' => !empty($parsed['p3']),
                'parsed'    => $parsed,
            ]);

            if (empty($parsed['p1'])) {
                Log::error('[POSITIONNEMENT] ❌ Structure IA invalide — p1 vide', ['data' => $parsed]);
                return response()->json(['error' => 'Réponse invalide de l\'IA. Réessaie.'], 500);
            }

            // LOG 10 — Avant sauvegarde BDD
            Log::info('[POSITIONNEMENT] Tentative PositioningGeneration::create');

            $generation = PositioningGeneration::create([
                'ip_address'      => $request->ip(),
                'user_agent'      => $request->userAgent(),
                'metier'          => $request->metier,
                'techno'          => $request->techno,
                'niveau'          => $request->niveau,
                'cible'           => $request->cible,
                'resultat'        => $request->resultat,
                'approche'        => $request->approche,
                'extra'           => $request->extra,
                'usages'          => $usages,
                'ton'             => $ton,
                'longueur'        => $request->input('longueur', 2),
                'phrase_1'        => $parsed['p1'],
                'phrase_2'        => $parsed['p2'],
                'phrase_3'        => $parsed['p3'],
                'tip_linkedin'    => $parsed['tip_linkedin'] ?? null,
                'tip_portfolio'   => $parsed['tip_portfolio'] ?? null,
                'tip_freelance'   => $parsed['tip_freelance'] ?? null,
                'tip_candidature' => $parsed['tip_candidature'] ?? null,
            ]);

            // LOG 11 — Succès total
            Log::info('[POSITIONNEMENT] ✅ Génération terminée avec succès', [
                'generation_id' => $generation->id,
                'provider'      => $provider,
            ]);

            return response()->json(array_merge($parsed, ['generation_id' => $generation->id]));

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('[POSITIONNEMENT] ❌ QueryException BDD', [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Erreur BDD : ' . $e->getMessage()], 500);

        } catch (\Exception $e) {
            Log::error('[POSITIONNEMENT] ❌ Exception générale', [
                'class'   => get_class($e),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function retenirPhrase(Request $request, string $id)
    {
        Log::info('[POSITIONNEMENT] retenirPhrase()', ['id' => $id]);

        $request->validate(['phrase' => 'required|string|max:500']);
        $generation = PositioningGeneration::findOrFail($id);
        $generation->update(['phrase_retenue' => $request->phrase]);

        return response()->json(['ok' => true]);
    }

    private function line(string $label, ?string $value): string
    {
        return $value ? "- {$label} : {$value}" : '';
    }

    private function regenLine(bool $isRegen): string
    {
        return $isRegen ? '- IMPORTANT : génère des formulations différentes, innove !' : '';
    }
}