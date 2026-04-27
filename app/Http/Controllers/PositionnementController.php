<?php
// app/Http/Controllers/PositionnementController.php

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
        $this->aiService = $aiService;
    }

    public function index()
    {
        return view('positionnement.index');
    }

    public function generer(Request $request)
    {
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

        // Tracking usage
        ToolUsage::create([
            'tool_slug'  => 'positionnement',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $longueurMap = [
            1 => 'très courte et percutante (10 à 18 mots maximum)',
            2 => 'équilibrée (entre 20 et 30 mots)',
            3 => 'détaillée et complète (entre 30 et 45 mots)',
        ];

        $longueur = $longueurMap[$request->input('longueur', 2)];
        $ton      = $request->input('ton', 'professionnel et direct');
        $usages   = $request->input('usages', 'LinkedIn');
        $isRegen  = $request->boolean('regen');

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

        try {
            $aiResponse = $this->aiService->generateText($prompt, [
                'temperature' => $isRegen ? 0.9 : 0.75,
                'max_tokens'  => 1024,
            ]);

            if (!$aiResponse['success']) {
                Log::error('AI Service error', ['error' => $aiResponse['error']]);
                return response()->json(['error' => $aiResponse['error']], 502);
            }

            $parsed = $aiResponse['data'];
            $provider = $aiResponse['provider'] ?? 'unknown';

            if (empty($parsed['p1'])) {
                Log::error('Invalid AI response structure', ['data' => $parsed]);
                return response()->json(['error' => 'Réponse invalide de l\'IA. Réessaie.'], 500);
            }

            Log::info('Positionnement generated', ['provider' => $provider]);

            // Sauvegarde pour dataset IA
            $generation = PositioningGeneration::create([
                'ip_address'   => $request->ip(),
                'user_agent'   => $request->userAgent(),
                'metier'       => $request->metier,
                'techno'       => $request->techno,
                'niveau'       => $request->niveau,
                'cible'        => $request->cible,
                'resultat'     => $request->resultat,
                'approche'     => $request->approche,
                'extra'        => $request->extra,
                'usages'       => $usages,
                'ton'          => $ton,
                'longueur'     => $request->input('longueur', 2),
                'phrase_1'     => $parsed['p1'],
                'phrase_2'     => $parsed['p2'],
                'phrase_3'     => $parsed['p3'],
                'tip_linkedin'    => $parsed['tip_linkedin'] ?? null,
                'tip_portfolio'   => $parsed['tip_portfolio'] ?? null,
                'tip_freelance'   => $parsed['tip_freelance'] ?? null,
                'tip_candidature' => $parsed['tip_candidature'] ?? null,
            ]);

            return response()->json(array_merge($parsed, ['generation_id' => $generation->id]));

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error in Positionnement', ['msg' => $e->getMessage(), 'code' => $e->getCode()]);
            return response()->json(['error' => 'Erreur de base de données. Réessaie plus tard.'], 500);
        } catch (\Exception $e) {
            Log::error('Positionnement exception', ['msg' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Connexion impossible. Vérifie ta connexion.'], 500);
        }
    }

    // Endpoint appelé quand l'user copie/choisit une phrase
    public function retenirPhrase(Request $request, string $id)
    {
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
