<?php

namespace App\Http\Controllers;

use App\Models\ToolUsage;
use App\Services\DynamicAIService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LinkedinAnalyseController extends Controller
{
    public function __construct(private readonly DynamicAIService $aiService) {}

    public function index(): View
    {
        return view('linkedin.analyse', [
            'result'  => session('linkedin_analysis'),
            'excerpt' => session('linkedin_excerpt'),
            'source'  => session('linkedin_source', 'paste'),
        ]);
    }

    public function analyser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'input_mode'   => ['required', 'in:url,paste'],
            'profil_url'   => ['nullable', 'string', 'max:500'],
            'profil_texte' => ['nullable', 'string', 'min:30', 'max:8000'],
        ]);

        $profileText  = '';
        $profileMeta  = [];
        $source       = $validated['input_mode'];

        // ── Mode URL : scraping automatique ──────────────────────
        if ($source === 'url') {
            $url = trim($validated['profil_url'] ?? '');

            if (empty($url)) {
                return back()->withInput()->withErrors(['profil_url' => 'Colle ton URL LinkedIn (ex: linkedin.com/in/monpseudo).']);
            }

            // Normalise l'URL
            if (!str_starts_with($url, 'http')) {
                $url = 'https://' . $url;
            }

            if (!preg_match('/linkedin\.com\/in\//i', $url)) {
                return back()->withInput()->withErrors(['profil_url' => 'URL invalide — elle doit contenir linkedin.com/in/tenpseudo']);
            }

            $scraped = $this->scrapeByUrl($url);

            if (!$scraped) {
                return back()->withInput()->withErrors([
                    'profil_url' => 'Impossible de récupérer ce profil automatiquement. Vérifie que RAPIDAPI_KEY est configurée, ou utilise l\'onglet "Coller" pour coller le contenu manuellement.',
                ]);
            }

            $profileText = $scraped['text'];
            $profileMeta = $scraped['meta'];
        }

        // ── Mode Paste ────────────────────────────────────────────
        else {
            $profileText = trim($validated['profil_texte'] ?? '');
            if (empty($profileText)) {
                return back()->withInput()->withErrors(['profil_texte' => 'Colle le contenu de ton profil LinkedIn.']);
            }
        }

        // ── Analyse IA ────────────────────────────────────────────
        $prompt   = $this->buildPrompt($profileText);
        $aiResult = $this->aiService->generateText($prompt, ['temperature' => 0.25, 'max_tokens' => 2200]);

        if (empty($aiResult['success']) || empty($aiResult['content'])) {
            return back()->withInput()->withErrors(['general' => 'Analyse impossible en ce moment. Réessaie dans quelques instants.']);
        }

        $data = $this->parseJson($aiResult['content']);

        if (!$data || !isset($data['score_global'])) {
            Log::warning('[LinkedinAnalyse] JSON invalide', ['raw' => mb_substr($aiResult['content'], 0, 500)]);
            return back()->withInput()->withErrors(['general' => 'Résultat invalide. Réessaie.']);
        }

        if (!empty($profileMeta)) {
            $data['profile_meta'] = $profileMeta;
        }

        try {
            ToolUsage::create([
                'tool_slug'  => 'linkedin_analyse',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception) {}

        session()->flash('linkedin_analysis', $data);
        session()->flash('linkedin_excerpt', mb_substr($profileText, 0, 300));
        session()->flash('linkedin_source', $source);

        return redirect()->route('linkedin.analyse');
    }

    // ────────────────────────────────────────────────────────────────
    // SCRAPING BY URL
    // ────────────────────────────────────────────────────────────────

    private function scrapeByUrl(string $url): ?array
    {
        // Tentative 1 : Real-Time LinkedIn Scraper API (RockApis)
        $res = $this->rapidApiCall(
            'linkedin-data-api.p.rapidapi.com',
            '/get-profile-data-by-url',
            ['url' => $url]
        );
        if ($res && $res->successful()) {
            $raw = $res->json('data', $res->json());
            if (!empty($raw) && (isset($raw['firstName']) || isset($raw['headline']))) {
                return $this->buildScrapedPayload($raw, $url);
            }
        }

        // Tentative 2 : LI Data Scraper
        $res2 = $this->rapidApiCall(
            'li-data-scraper.p.rapidapi.com',
            '/get-profile',
            ['url' => $url]
        );
        if ($res2 && $res2->successful()) {
            $raw2 = $res2->json('data', $res2->json());
            if (!empty($raw2)) {
                return $this->buildScrapedPayload($raw2, $url);
            }
        }

        return null;
    }

    private function rapidApiCall(string $host, string $path, array $params): ?\Illuminate\Http\Client\Response
    {
        $key = config('services.rapidapi.key');
        if (!$key) {
            Log::warning('[LinkedinAnalyse] RAPIDAPI_KEY non configurée');
            return null;
        }

        try {
            return Http::timeout(25)
                ->withHeaders(['x-rapidapi-key' => $key, 'x-rapidapi-host' => $host])
                ->get("https://{$host}{$path}", $params);
        } catch (\Exception $e) {
            Log::warning("[LinkedinAnalyse] API {$host}: " . $e->getMessage());
            return null;
        }
    }

    private function buildScrapedPayload(array $raw, string $url): array
    {
        $firstName = $raw['firstName'] ?? $raw['first_name'] ?? '';
        $lastName  = $raw['lastName']  ?? $raw['last_name']  ?? '';
        $name      = trim("{$firstName} {$lastName}");

        return [
            'text' => $this->rawToText($raw),
            'meta' => [
                'name'     => $name ?: null,
                'headline' => $raw['headline'] ?? $raw['title'] ?? null,
                'location' => $raw['location'] ?? $raw['geo']['full'] ?? null,
                'avatar'   => $raw['profilePicture'] ?? $raw['photo'] ?? $raw['picture'] ?? null,
                'url'      => $url,
            ],
        ];
    }

    private function rawToText(array $raw): string
    {
        $lines = [];

        $name = trim(($raw['firstName'] ?? '') . ' ' . ($raw['lastName'] ?? ''));
        if ($name) $lines[] = "Nom : {$name}";
        if ($h = $raw['headline'] ?? $raw['title'] ?? '') $lines[] = "Titre LinkedIn : {$h}";
        if ($l = $raw['location'] ?? $raw['geo']['full'] ?? '') $lines[] = "Localisation : {$l}";
        if ($s = $raw['summary'] ?? $raw['about'] ?? '') $lines[] = "À propos :\n{$s}";

        // Compétences
        $skills = $raw['skills'] ?? [];
        if ($skills) {
            $names = array_filter(array_map(fn($s) => is_array($s) ? ($s['name'] ?? '') : (string)$s, array_slice($skills, 0, 25)));
            $lines[] = "Compétences : " . implode(', ', $names);
        }

        // Expériences
        $exps = $raw['experience'] ?? $raw['experiences'] ?? $raw['positions'] ?? [];
        if ($exps) {
            $expLines = [];
            foreach (array_slice($exps, 0, 6) as $e) {
                $title   = $e['title'] ?? $e['position'] ?? '';
                $company = $e['company'] ?? $e['companyName'] ?? $e['company_name'] ?? '';
                $desc    = $e['description'] ?? '';
                $period  = ($e['startDate'] ?? '') . ($e['endDate'] ?? $e['start_date'] ?? '');
                $l = implode(' @ ', array_filter([$title, $company]));
                if ($period) $l .= " ({$period})";
                if ($desc)   $l .= "\n  " . mb_substr(strip_tags($desc), 0, 200);
                if ($l) $expLines[] = "- {$l}";
            }
            if ($expLines) $lines[] = "Expériences :\n" . implode("\n", $expLines);
        }

        // Formation
        $edus = $raw['education'] ?? $raw['educations'] ?? [];
        if ($edus) {
            $eduLines = [];
            foreach (array_slice($edus, 0, 3) as $e) {
                $school = $e['school'] ?? $e['schoolName'] ?? '';
                $degree = $e['degree'] ?? $e['fieldOfStudy'] ?? '';
                if ($school) $eduLines[] = implode(' — ', array_filter([$degree, $school]));
            }
            if ($eduLines) $lines[] = "Formation : " . implode(' | ', $eduLines);
        }

        // Langues + connexions
        $langs = $raw['languages'] ?? [];
        if ($langs) {
            $ln = array_filter(array_map(fn($l) => is_array($l) ? ($l['name'] ?? '') : (string)$l, $langs));
            if ($ln) $lines[] = "Langues : " . implode(', ', $ln);
        }
        if (!empty($raw['connections']))       $lines[] = "Connexions LinkedIn : " . $raw['connections'];
        if (!empty($raw['recommendations']))   $lines[] = "Recommandations reçues : " . count((array)$raw['recommendations']);
        if (!empty($raw['followersCount']))    $lines[] = "Abonnés : " . $raw['followersCount'];

        return implode("\n\n", array_filter($lines));
    }

    // ────────────────────────────────────────────────────────────────
    // PROMPT
    // ────────────────────────────────────────────────────────────────

    private function buildPrompt(string $profileText): string
    {
        return <<<PROMPT
Tu es un expert en personal branding, carrière remote et optimisation de profil LinkedIn pour les professionnels africains qui ciblent des clients et opportunités internationaux (Europe, Canada, USA).

PROFIL À ANALYSER :
{$profileText}

MISSION DOUBLE — fais les DEUX à la fois :

1. ANALYSE COMPLÈTE du profil (score, catégories, recommandations concrètes)
2. GÉNÈRE 3 PHRASES DE POSITIONNEMENT prêtes-à-l'emploi

Règles pour les phrases de positionnement :
- Concrètes, percutantes, avec chiffres ou résultats si disponibles
- Mentionnent le remote, la disponibilité internationale
- Adaptées au contexte africain (avantage géo, bilinguisme, tarifs compétitifs)
- Longueur max 220 caractères chacune
- Style LinkedIn : Titre clair | Bénéfice | Disponibilité

Retourne UNIQUEMENT le JSON suivant (aucun texte autour, aucun markdown) :
{
  "score_global": <0-100>,
  "niveau": "<Débutant|En progression|Bon profil|Excellent profil>",
  "resume_global": "<2 phrases max résumant le profil et son potentiel>",
  "categories": {
    "titre":       { "score": <0-20>, "commentaire": "<conseil court>" },
    "resume":      { "score": <0-20>, "commentaire": "<conseil court>" },
    "competences": { "score": <0-20>, "commentaire": "<conseil court>" },
    "experiences": { "score": <0-20>, "commentaire": "<conseil court>" },
    "visibilite":  { "score": <0-20>, "commentaire": "<conseil court>" }
  },
  "forces": ["<force 1>", "<force 2>", "<force 3>"],
  "recommandations": [
    { "priorite": "haute",   "action": "<action spécifique>", "impact": "<bénéfice mesurable>" },
    { "priorite": "haute",   "action": "<action spécifique>", "impact": "<bénéfice mesurable>" },
    { "priorite": "moyenne", "action": "<action spécifique>", "impact": "<bénéfice mesurable>" },
    { "priorite": "moyenne", "action": "<action spécifique>", "impact": "<bénéfice mesurable>" },
    { "priorite": "basse",   "action": "<action spécifique>", "impact": "<bénéfice mesurable>" }
  ],
  "actions_immediates": ["<faisable en 5 min>", "<faisable en 5 min>", "<faisable en 5 min>"],
  "positionnement": {
    "p1": "<Phrase 1 — orientée LinkedIn Headline>",
    "p2": "<Phrase 2 — version narrative/storytelling>",
    "p3": "<Phrase 3 — orientée résultats/impact chiffré>"
  }
}
PROMPT;
    }

    // ────────────────────────────────────────────────────────────────
    // UTILS
    // ────────────────────────────────────────────────────────────────

    private function parseJson(string $raw): ?array
    {
        $clean = preg_replace('/```(?:json)?\s*/i', '', trim($raw));
        $clean = preg_replace('/\s*```/', '', $clean);
        if (preg_match('/\{.*\}/s', trim($clean), $m)) {
            $clean = $m[0];
        }
        $data = json_decode(trim($clean), true);
        return is_array($data) ? $data : null;
    }
}
