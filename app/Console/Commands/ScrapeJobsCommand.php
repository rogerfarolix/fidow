<?php

namespace App\Console\Commands;

use App\Services\MultiSourceScraperService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScrapeJobsCommand extends Command
{
    protected $signature   = 'digest:scrape {--source= : Scrape une source spécifique seulement}';
    protected $description = 'Scrape les sources d\'emploi remote et met à jour la base job_listings';

    public function handle(): int
    {
        $this->info('🔍 Démarrage de la mise en file d\'attente du scraping multi-sources...');

        $sources = [
            'remotive',
            'workingnomads',
            'weworkremotely',
            'jobicy',
            'jobspresso',
            'indeed',
            'linkedin'
        ];

        $specificSource = $this->option('source');

        if ($specificSource) {
            if (!in_array($specificSource, $sources)) {
                $this->error("❌ Source inconnue : {$specificSource}");
                return Command::FAILURE;
            }
            \App\Jobs\ScrapeSourceJob::dispatch($specificSource);
            $this->info("✅ Job dispatché pour la source : {$specificSource}");
        } else {
            foreach ($sources as $source) {
                \App\Jobs\ScrapeSourceJob::dispatch($source);
            }
            $this->info("✅ " . count($sources) . " jobs dispatchés avec succès.");
        }

        return Command::SUCCESS;
    }
}
