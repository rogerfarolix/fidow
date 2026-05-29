<?php

namespace App\Services;

use App\Models\JobListing;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

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
            // ── Sources JSON / API publiques gratuites ────────────────────
            'remotive'        => fn() => $this->fetchRemotive(),
            'workingnomads'   => fn() => $this->fetchWorkingNomads(),
            'remoteok'        => fn() => $this->fetchRemoteOk(),

            // ── Sources RSS ───────────────────────────────────────────────
            'weworkremotely'  => fn() => $this->fetchWWR(),
            'jobicy'          => fn() => $this->fetchRSS('https://jobicy.com/?feed=job_feed', 'jobicy'),
            'jobspresso'      => fn() => $this->fetchRSS('https://jobspresso.co/feed/', 'jobspresso'),

            // ── Sources Python (Scrapling / Anti-bot bypass) ──────────────
            'indeed'          => fn() => $this->fetchViaPython('indeed'),
            'linkedin'        => fn() => $this->fetchViaPython('linkedin'),
            'justremote'      => fn() => $this->fetchViaPython('justremote'),
            'wellfound'       => fn() => $this->fetchViaPython('wellfound'),
            'flexjobs'        => fn() => $this->fetchViaPython('flexjobs'),
            'missionfreelance'=> fn() => $this->fetchViaPython('missionfreelance'),
            '404works'        => fn() => $this->fetchViaPython('404works'),
            'jobbers'         => fn() => $this->fetchViaPython('jobbers'),
            'freenest'        => fn() => $this->fetchViaPython('freenest'),

            // ── RapidAPI (plans gratuits) ─────────────────────────────────
            'linkedin_api'    => fn() => $this->fetchLinkedInRapidApi(),
            'li_scraper'      => fn() => $this->fetchLiDataScraper(),
            'websearch_ats'   => fn() => $this->fetchWebSearchJobs(),
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
     * Point d'entrée pour le scraping asynchrone (par source)
     */
    public function scrapeSingleSource(string $sourceName): void
    {
        $sources = [
            'remotive'        => fn() => $this->fetchRemotive(),
            'workingnomads'   => fn() => $this->fetchWorkingNomads(),
            'remoteok'        => fn() => $this->fetchRemoteOk(),
            'weworkremotely'  => fn() => $this->fetchWWR(),
            'jobicy'          => fn() => $this->fetchRSS('https://jobicy.com/?feed=job_feed', 'jobicy'),
            'jobspresso'      => fn() => $this->fetchRSS('https://jobspresso.co/feed/', 'jobspresso'),
            'indeed'          => fn() => $this->fetchViaPython('indeed'),
            'linkedin'        => fn() => $this->fetchViaPython('linkedin'),
            'justremote'      => fn() => $this->fetchViaPython('justremote'),
            'wellfound'       => fn() => $this->fetchViaPython('wellfound'),
            'flexjobs'        => fn() => $this->fetchViaPython('flexjobs'),
            'missionfreelance'=> fn() => $this->fetchViaPython('missionfreelance'),
            '404works'        => fn() => $this->fetchViaPython('404works'),
            'jobbers'         => fn() => $this->fetchViaPython('jobbers'),
            'freenest'        => fn() => $this->fetchViaPython('freenest'),
            'linkedin_api'    => fn() => $this->fetchLinkedInRapidApi(),
            'li_scraper'      => fn() => $this->fetchLiDataScraper(),
            'websearch_ats'   => fn() => $this->fetchWebSearchJobs(),
        ];

        if (!isset($sources[$sourceName])) {
            throw new \Exception("Source de scraping inconnue: {$sourceName}");
        }

        $jobs = $sources[$sourceName]();
        
        $scraped = 0;
        foreach ($jobs as $job) {
            if ($this->saveJob($job)) {
                $scraped++;
            }
        }
        Log::info("[DigestScraper] Single source {$sourceName} terminé. Nouvelles offres: {$scraped}");
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
        $exists = JobListing::query()->where('fingerprint', $fingerprint)->exists()
               || JobListing::query()->where('url', $job['url'])->exists();

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

    private function fetchRemoteOk(): array
    {
        $jobs = [];
        try {
            $response = Http::timeout(10)->get('https://remoteok.com/api');
            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && count($data) > 0) {
                    array_shift($data); // Retire le premier élément (informations légales)
                    foreach ($data as $item) {
                        if (empty($item['id'])) continue;
                        
                        $jobs[] = [
                            'source' => 'remoteok',
                            'title' => $item['position'] ?? 'Unknown Title',
                            'company' => $item['company'] ?? 'Unknown',
                            'url' => $item['url'] ?? '',
                            'description' => strip_tags($item['description'] ?? ''),
                            'tags' => $item['tags'] ?? [],
                            'country' => $item['location'] ?? 'Worldwide',
                            'contract_type' => 'full_time',
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning("[DigestScraper] Erreur fetchRemoteOk: " . $e->getMessage());
        }
        return $jobs;
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
     * Exécute le script Python Scrapling pour contourner les anti-bots.
     */
    private function fetchViaPython(string $source): array
    {
        $scriptPath = base_path('python_scrapers/main.py');
        $pythonBin = base_path('python_scrapers/venv/bin/python3');

        $process = new Process([$pythonBin, $scriptPath, '--source', $source]);
        $process->setTimeout(180); // Le scraping via navigateur headless peut être lent
        
        $proxies = env('SCRAPING_PROXIES');
        if ($proxies) {
            $process->setEnv(['SCRAPING_PROXIES' => $proxies]);
        }
        
        try {
            $process->mustRun();
            
            $output = $process->getOutput();
            $jobs = json_decode($output, true);
            
            if (!is_array($jobs)) {
                Log::error("[DigestScraper] Sortie invalide depuis Python pour {$source}: {$output}");
                return [];
            }
            
            return $jobs;
        } catch (\Exception $e) {
            Log::error("[DigestScraper] Échec de fetchViaPython pour {$source}: " . $e->getMessage());
            if (isset($process) && $process instanceof Process) {
                Log::error("[DigestScraper] Python STDERR: " . $process->getErrorOutput());
            }
            throw $e;
        }
    }

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

    // ─────────────────────────────────────────────────────────────────────────
    // RAPIDAPI — Sources premium (plans gratuits disponibles)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Client HTTP centralisé pour toutes les APIs RapidAPI.
     * Retourne null si la clé n'est pas configurée.
     */
    private function rapidApiGet(string $host, string $path, array $params = []): ?\Illuminate\Http\Client\Response
    {
        $key = config('services.rapidapi.key');
        if (!$key) {
            return null;
        }

        try {
            return Http::timeout(30)
                ->withHeaders([
                    'x-rapidapi-key'  => $key,
                    'x-rapidapi-host' => $host,
                ])
                ->get("https://{$host}{$path}", $params);
        } catch (\Exception $e) {
            Log::warning("[DigestScraper] RapidAPI ({$host}{$path}): " . $e->getMessage());
            return null;
        }
    }

    /**
     * LinkedIn — Real-Time LinkedIn Scraper API (RockApis)
     * Host: linkedin-data-api.p.rapidapi.com
     * Plan gratuit : ~100 req/mois
     * Recherche par mots-clés configurables via RAPIDAPI_LINKEDIN_KEYWORDS.
     */
    private function fetchLinkedInRapidApi(): array
    {
        $keywordsRaw = config('services.rapidapi.linkedin_keywords', '');
        $keywords = array_filter(array_map('trim', explode(',', $keywordsRaw)));

        if (empty($keywords)) {
            return [];
        }

        $allJobs = [];

        foreach ($keywords as $keyword) {
            $response = $this->rapidApiGet(
                'linkedin-data-api.p.rapidapi.com',
                '/search-jobs',
                [
                    'keywords'   => $keyword,
                    'locationId' => '92000000', // Worldwide
                    'datePosted' => 'pastWeek',
                ]
            );

            if (!$response || !$response->successful()) {
                Log::warning("[DigestScraper] linkedin_api: réponse vide pour «{$keyword}»");
                usleep(400000);
                continue;
            }

            foreach ($response->json('data', []) as $item) {
                $company = is_array($item['company'] ?? null)
                    ? ($item['company']['name'] ?? '')
                    : ($item['company'] ?? '');

                $salary  = is_array($item['salary'] ?? null) ? $item['salary'] : null;

                $url = $item['url'] ?? '';
                if (empty($url) || empty($item['title'] ?? '')) {
                    continue;
                }

                $allJobs[] = [
                    'source'        => 'linkedin_api',
                    'title'         => $item['title'],
                    'company'       => $company,
                    'url'           => $url,
                    'description'   => strip_tags($item['description'] ?? ''),
                    'tags'          => $this->extractTagsFromText(($item['title'] ?? '') . ' ' . ($item['description'] ?? '')),
                    'country'       => $item['location'] ?? 'Worldwide',
                    'contract_type' => $this->normalizeContractType($item['type'] ?? $item['employmentType'] ?? ''),
                    'salary_min'    => $salary['min'] ?? $salary['salaryMin'] ?? null,
                    'salary_max'    => $salary['max'] ?? $salary['salaryMax'] ?? null,
                ];
            }

            usleep(400000); // 400 ms entre chaque appel — respecter le rate limit
        }

        return $allJobs;
    }

    /**
     * LI Data Scraper (LiScraper)
     * Host: li-data-scraper.p.rapidapi.com
     * Plan gratuit disponible — très rapide (91 ms)
     * Complément de linkedin_api pour une couverture maximale.
     */
    private function fetchLiDataScraper(): array
    {
        $response = $this->rapidApiGet(
            'li-data-scraper.p.rapidapi.com',
            '/search-jobs',
            [
                'keywords' => 'remote developer engineer designer',
                'location' => 'Worldwide',
            ]
        );

        if (!$response || !$response->successful()) {
            return [];
        }

        // L'API peut retourner { jobs: [...] } ou { data: [...] } selon la version
        $items = $response->json('jobs', $response->json('data', []));
        $jobs  = [];

        foreach ($items as $item) {
            $url   = $item['jobUrl'] ?? $item['url'] ?? '';
            $title = $item['title'] ?? '';
            if (!$url || !$title) {
                continue;
            }

            $jobs[] = [
                'source'        => 'li_scraper',
                'title'         => $title,
                'company'       => $item['companyName'] ?? $item['company'] ?? '',
                'url'           => $url,
                'description'   => strip_tags($item['description'] ?? ''),
                'tags'          => $this->extractTagsFromText($title . ' ' . ($item['description'] ?? '')),
                'country'       => $item['location'] ?? 'Worldwide',
                'contract_type' => $this->normalizeContractType($item['contractType'] ?? $item['type'] ?? ''),
                'salary_min'    => null,
                'salary_max'    => null,
            ];
        }

        return $jobs;
    }

    /**
     * Real-Time Web Search → offres sur les ATS (Greenhouse, Lever, Ashby, Workday)
     * Host: real-time-web-search.p.rapidapi.com
     * Plan gratuit : ~100 req/mois
     *
     * Stratégie : chercher directement sur Google les jobs publiés sur les ATS
     * des startups/scale-ups (Greenhouse, Lever, Ashby) — couvre des milliers
     * d'entreprises qu'aucun autre scraper n'atteint.
     */
    private function fetchWebSearchJobs(): array
    {
        $queriesRaw = config('services.rapidapi.websearch_queries', '');
        $queries    = array_filter(array_map('trim', explode('|', $queriesRaw)));

        if (empty($queries)) {
            return [];
        }

        $allJobs = [];

        foreach ($queries as $query) {
            $response = $this->rapidApiGet(
                'real-time-web-search.p.rapidapi.com',
                '/search',
                ['q' => $query, 'limit' => 20]
            );

            if (!$response || !$response->successful()) {
                usleep(400000);
                continue;
            }

            foreach ($response->json('data', []) as $item) {
                $url   = $item['url'] ?? '';
                $title = $item['title'] ?? '';

                if (!$url || !$title || !$this->looksLikeAtsJobUrl($url)) {
                    continue;
                }

                $allJobs[] = [
                    'source'        => 'websearch_ats',
                    'title'         => $this->cleanWebJobTitle($title),
                    'company'       => $this->extractCompanyFromAtsUrl($url),
                    'url'           => $url,
                    'description'   => $item['description'] ?? '',
                    'tags'          => $this->extractTagsFromText($title . ' ' . ($item['description'] ?? '')),
                    'country'       => 'Worldwide',
                    'contract_type' => 'full_time',
                    'salary_min'    => null,
                    'salary_max'    => null,
                ];
            }

            usleep(400000);
        }

        return $allJobs;
    }

    /**
     * Enrichit un JobListing existant avec les données salariales Glassdoor
     * via Job Salary Data (OpenWeb Ninja).
     * Host: job-salary-data.p.rapidapi.com
     * Appelé par EnrichJobSalaryCommand, pas par scrapeAll().
     */
    public function enrichWithSalary(\App\Models\JobListing $job): bool
    {
        $response = $this->rapidApiGet(
            'job-salary-data.p.rapidapi.com',
            '/',
            [
                'job_title' => $job->title,
                'location'  => $job->country && $job->country !== 'Worldwide' ? $job->country : 'United States',
                'radius'    => '200',
            ]
        );

        if (!$response || !$response->successful()) {
            return false;
        }

        $salaries = $response->json('salaries', []);
        if (empty($salaries)) {
            return false;
        }

        $first = $salaries[0];
        $min   = $first['salary_percentile_25'] ?? $first['min_salary'] ?? null;
        $max   = $first['salary_percentile_75'] ?? $first['max_salary'] ?? null;

        if (!$min && !$max) {
            return false;
        }

        $job->update(['salary_min' => $min, 'salary_max' => $max]);
        return true;
    }

    // ── Helpers web search ────────────────────────────────────────────────────

    /**
     * Vérifie qu'une URL ressemble à une offre d'emploi sur un ATS connu.
     */
    private function looksLikeAtsJobUrl(string $url): bool
    {
        $atsPatterns = [
            'greenhouse.io',
            'lever.co',
            'jobs.ashbyhq.com',
            'apply.workable.com',
            'boards.eu.greenhouse.io',
        ];

        foreach ($atsPatterns as $pattern) {
            if (str_contains($url, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Nettoie un titre de job venant d'un résultat Google (retire le suffixe " | Greenhouse" etc.).
     */
    private function cleanWebJobTitle(string $title): string
    {
        // Retire "| Greenhouse", "- Lever", "at Company" en fin de titre
        $title = preg_replace('/\s*[\|\-–]\s*(greenhouse|lever|ashby|workable|workday|jobs|careers).*$/i', '', $title);
        return trim($title);
    }

    /**
     * Extrait le nom de la société depuis une URL ATS.
     */
    private function extractCompanyFromAtsUrl(string $url): string
    {
        // boards.greenhouse.io/companyslug/jobs/123
        if (preg_match('#greenhouse\.io/([^/?#]+)#i', $url, $m)) {
            return ucwords(str_replace(['-', '_'], ' ', $m[1]));
        }
        // jobs.lever.co/companyslug/uuid
        if (preg_match('#lever\.co/([^/?#]+)#i', $url, $m)) {
            return ucwords(str_replace(['-', '_'], ' ', $m[1]));
        }
        // jobs.ashbyhq.com/companyslug/uuid
        if (preg_match('#ashbyhq\.com/([^/?#]+)#i', $url, $m)) {
            return ucwords(str_replace(['-', '_'], ' ', $m[1]));
        }
        // apply.workable.com/companyslug/j/uuid
        if (preg_match('#workable\.com/([^/?#]+)/j/#i', $url, $m)) {
            return ucwords(str_replace(['-', '_'], ' ', $m[1]));
        }

        return 'Unknown';
    }
}
