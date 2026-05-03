<?php

namespace App\Console\Commands;

use App\Services\MultiSourceScraperService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScrapeJobsCommand extends Command
{
    protected $signature   = 'digest:scrape {--source= : Scrape une source spécifique seulement}';
    protected $description = 'Scrape les sources d\'emploi remote et met à jour la base job_listings';

    public function handle(MultiSourceScraperService $scraper): int
    {
        $this->info('🔍 Démarrage du scraping multi-sources...');
        $start = microtime(true);

        try {
            $results = $scraper->scrapeAll();

            $duration = round(microtime(true) - $start, 2);

            $this->newLine();
            $this->info("✅ Scraping terminé en {$duration}s");
            $this->table(
                ['Métrique', 'Valeur'],
                [
                    ['Offres ajoutées',  $results['scraped']],
                    ['Doublons ignorés', $results['skipped']],
                    ['Erreurs sources',  count($results['errors'])],
                ]
            );

            if (!empty($results['errors'])) {
                $this->newLine();
                $this->warn('Sources avec erreurs (best-effort — non bloquant) :');
                foreach ($results['errors'] as $source => $error) {
                    $this->line("  ⚠️  {$source}: {$error}");
                }
            }

            Log::info('[DigestScrape] Terminé', [
                'scraped'  => $results['scraped'],
                'skipped'  => $results['skipped'],
                'errors'   => $results['errors'],
                'duration' => $duration,
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Erreur critique : ' . $e->getMessage());
            Log::error('[DigestScrape] Erreur critique', ['message' => $e->getMessage()]);
            return Command::FAILURE;
        }
    }
}
