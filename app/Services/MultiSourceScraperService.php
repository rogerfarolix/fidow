<?php

namespace App\Services;

use App\Models\JobListing;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

/**
 * Scrape multi-sources des offres d'emploi remote.
 * Stratégie best-effort : chaque source est essayée indépendamment.
 * Un échec sur une source n'interrompt pas les autres.
 */
class MultiSourceScraperService
{
    /** Correspondance domain → mots-clés de catégorie source */
    private array $domainKeywords = [
        'dev'       => ['developer', 'engineer', 'laravel', 'php', 'python', 'javascript', 'backend', 'frontend', 'fullstack', 'devops', 'mobile', 'react', 'vue', 'angular', 'node', 'développeur', 'ingeniero'],
        'design'    => ['design', 'ux', 'ui', 'figma', 'graphic', 'illustrator', 'branding', 'motion'],
        'marketing' => ['marketing', 'seo', 'growth', 'content', 'copywriting', 'social media', 'email marketing', 'paid'],
        'cyber'     => ['security', 'cybersecurity', 'pentest', 'soc', 'infosec', 'compliance', 'sécurité'],
        'data'      => ['data', 'analyst', 'machine learning', 'ai', 'ml', 'scientist', 'analytics', 'bi', 'intelligence'],
        'product'   => ['product', 'scrum', 'agile', 'project manager', 'chef de projet', 'product owner'],
    ];

    /**
     * Point d'entrée principal : scrape toutes les sources.
     */
    public function scrapeAll(): array
    {
        $results = ['scraped' => 0, 'skipped' => 0, 'errors' => []];

        $sources = [
            // ── Sources JSON (API publiques) ──────────────────────────────
            'remotive'       => fn() => $this->fetchRemotive(),
            'workingnomads'  => fn() => $this->fetchWorkingNomads(),

            // ── Sources RSS ───────────────────────────────────────────────
            'weworkremotely' => fn() => $this->fetchWWR(),
            'jobicy'         => fn() => $this->fetchRSS('https://jobicy.com/?feed=job_feed', 'jobicy'),
            'jobspresso'     => fn() => $this->fetchRSS('https://jobspresso.co/feed/', 'jobspresso'),
        ];

        foreach ($sources as $source => $fetcher) {
            try {
                Log::info("[DigestScraper] Scraping {$source}...");
                $jobs = $fetcher();
                Log::info("[DigestScraper] {$source}: " . count($jobs) . " offres récupérées");

                foreach ($jobs as $job) {
                    if ($this->saveJob($job)) {
                        $results['scraped']++;
                    } else {
                        $results['skipped']++;
                    }
                }
            } catch (\Exception $e) {
                $results['errors'][$source] = $e->getMessage();
                Log::warning("[DigestScraper] Erreur sur {$source}: " . $e->getMessage());
            }
        }

        Log::info('[DigestScraper] Terminé', $results);
        return $results;
    }

    /**
     * Sauvegarde une offre normalisée. Retourne true si nouvelle, false si doublon.
     */
    private function saveJob(array $job): bool
    {
        if (empty($job['url']) || empty($job['title'])) {
            return false;
        }

        $fingerprint = JobListing::makeFingerprint(
            $job['title'],
            $job['company'] ?? '',
            $job['url']
        );

        // Upsert silencieux : si doublon, on ignore
        $exists = JobListing::where('fingerprint', $fingerprint)->exists()
               || JobListing::where('url', $job['url'])->exists();

        if ($exists) {
            return false;
        }

        try {
            JobListing::create([
                'id'            => \Illuminate\Support\Str::uuid(),
                'source'        => $job['source'],
                'fingerprint'   => $fingerprint,
                'title'         => mb_substr($job['title'], 0, 250),
                'company'       => mb_substr($job['company'] ?? 'Non précisé', 0, 150),
                'url'           => $job['url'],
                'description'   => mb_substr($job['description'] ?? '', 0, 5000),
                'tags'          => $job['tags'] ?? [],
                'country'       => mb_substr($job['country'] ?? 'Worldwide', 0, 80),
                'contract_type' => $job['contract_type'] ?? null,
                'salary_min'    => $job['salary_min'] ?? null,
                'salary_max'    => $job['salary_max'] ?? null,
                'domain'        => $this->detectDomain($job),
                'remote'        => true,
                'scraped_at'    => now(),
                'expires_at'    => now()->addDays(14),
            ]);
            return true;
        } catch (\Exception $e) {
            Log::debug("[DigestScraper] saveJob skip: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Détecte le domaine métier d'une offre à partir des tags et du titre.
     */
    private function detectDomain(array $job): string
    {
        $haystack = strtolower(
            ($job['title'] ?? '') . ' ' .
            ($job['description'] ?? '') . ' ' .
            implode(' ', $job['tags'] ?? [])
        );

        foreach ($this->domainKeywords as $domain => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($haystack, $kw)) {
                    return $domain;
                }
            }
        }

        return 'other';
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SOURCES
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Remotive.io — API JSON publique
     * https://remotive.com/api/remote-jobs
     */
    private function fetchRemotive(): array
    {
        $response = Http::timeout(20)->get('https://remotive.com/api/remote-jobs', [
            'limit' => 100,
        ]);

        if (!$response->successful()) {
            throw new \Exception("HTTP " . $response->status());
        }

        $jobs = $response->json('jobs', []);
        $normalized = [];

        foreach ($jobs as $job) {
            $normalized[] = [
                'source'        => 'remotive',
                'title'         => $job['title'] ?? '',
                'company'       => $job['company_name'] ?? '',
                'url'           => $job['url'] ?? '',
                'description'   => strip_tags($job['description'] ?? ''),
                'tags'          => $job['tags'] ?? [],
                'country'       => $job['candidate_required_location'] ?? 'Worldwide',
                'contract_type' => $this->normalizeContractType($job['job_type'] ?? ''),
                'salary_min'    => null,
                'salary_max'    => null,
            ];
        }

        return $normalized;
    }

    /**
     * Working Nomads — API JSON publique
     * https://www.workingnomads.com/api/exposed_jobs/
     */
    private function fetchWorkingNomads(): array
    {
        $response = Http::timeout(20)
            ->withHeaders(['User-Agent' => 'Fidow-RemoteDigest/1.0'])
            ->get('https://www.workingnomads.com/api/exposed_jobs/');

        if (!$response->successful()) {
            throw new \Exception("HTTP " . $response->status());
        }

        $jobs = $response->json();
        if (!is_array($jobs)) {
            return [];
        }

        $normalized = [];
        foreach (array_slice($jobs, 0, 100) as $job) {
            if (empty($job['url'])) continue;

            $normalized[] = [
                'source'        => 'workingnomads',
                'title'         => $job['title'] ?? '',
                'company'       => $job['company'] ?? '',
                'url'           => $job['url'],
                'description'   => strip_tags($job['description'] ?? ''),
                'tags'          => isset($job['tags']) ? (is_array($job['tags']) ? $job['tags'] : []) : [],
                'country'       => $job['location'] ?? 'Worldwide',
                'contract_type' => 'full_time',
                'salary_min'    => null,
                'salary_max'    => null,
            ];
        }

        return $normalized;
    }

    /**
     * We Work Remotely — Flux RSS
     */
    private function fetchWWR(): array
    {
        return $this->fetchRSS('https://weworkremotely.com/remote-jobs.rss', 'weworkremotely');
    }

    /**
     * Parser RSS générique.
     */
    private function fetchRSS(string $url, string $source): array
    {
        $response = Http::timeout(20)
            ->withHeaders([
                'User-Agent' => 'Fidow-RemoteDigest/1.0 (RSS Reader)',
                'Accept'     => 'application/rss+xml, application/xml, text/xml',
            ])
            ->get($url);

        if (!$response->successful()) {
            throw new \Exception("HTTP " . $response->status() . " for {$url}");
        }

        $body = $response->body();

        // Désactiver les erreurs XML
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($body);

        if ($xml === false) {
            throw new \Exception("XML parse error for {$url}");
        }

        $items  = $xml->channel->item ?? $xml->item ?? [];
        $normalized = [];

        foreach ($items as $item) {
            $title       = (string)($item->title ?? '');
            $link        = (string)($item->link ?? $item->guid ?? '');
            $description = strip_tags((string)($item->description ?? $item->summary ?? ''));
            $company     = (string)($item->author ?? $item->creator ?? '');

            // Pour WWR : le titre est souvent "Company: Position"
            if ($source === 'weworkremotely' && str_contains($title, ':')) {
                [$company, $title] = array_map('trim', explode(':', $title, 2));
            }

            if (empty($link) || empty($title)) continue;

            $normalized[] = [
                'source'        => $source,
                'title'         => $title,
                'company'       => $company,
                'url'           => $link,
                'description'   => mb_substr($description, 0, 3000),
                'tags'          => $this->extractTagsFromText($title . ' ' . $description),
                'country'       => 'Worldwide',
                'contract_type' => 'full_time',
                'salary_min'    => null,
                'salary_max'    => null,
            ];
        }

        return $normalized;
    }

    /**
     * Extrait des tags à partir du texte libre (pour les sources RSS sans tags structurés).
     */
    private function extractTagsFromText(string $text): array
    {
        $techKeywords = [
            'php', 'laravel', 'symfony', 'python', 'django', 'javascript', 'typescript',
            'react', 'vue', 'angular', 'node', 'nodejs', 'ruby', 'rails', 'go', 'golang',
            'rust', 'java', 'kotlin', 'swift', 'flutter', 'dart', 'aws', 'gcp', 'azure',
            'docker', 'kubernetes', 'devops', 'linux', 'sql', 'postgresql', 'mysql',
            'mongodb', 'redis', 'elasticsearch', 'graphql', 'rest', 'api', 'mobile',
            'android', 'ios', 'figma', 'design', 'ux', 'ui', 'marketing', 'seo',
            'data', 'ml', 'ai', 'machine learning', 'cybersecurity', 'security',
            'remote', 'freelance', 'full-time', 'part-time',
        ];

        $textLower = strtolower($text);
        $found = [];

        foreach ($techKeywords as $kw) {
            if (str_contains($textLower, $kw) && count($found) < 8) {
                $found[] = $kw;
            }
        }

        return array_values(array_unique($found));
    }

    /**
     * Normalise le type de contrat vers notre nomenclature interne.
     */
    private function normalizeContractType(string $type): string
    {
        $type = strtolower(trim($type));

        return match (true) {
            str_contains($type, 'full') => 'full_time',
            str_contains($type, 'part') => 'part_time',
            str_contains($type, 'freelance') || str_contains($type, 'contract') => 'freelance',
            str_contains($type, 'intern') => 'internship',
            default => 'full_time',
        };
    }
}
