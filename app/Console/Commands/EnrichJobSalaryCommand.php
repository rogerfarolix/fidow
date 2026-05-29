<?php

namespace App\Console\Commands;

use App\Models\JobListing;
use App\Services\MultiSourceScraperService;
use Illuminate\Console\Command;

class EnrichJobSalaryCommand extends Command
{
    protected $signature   = 'digest:enrich-salary {--limit=50 : Nombre max d\'offres à enrichir}';
    protected $description = 'Enrichit les offres d\'emploi sans salaire via Job Salary Data (RapidAPI)';

    public function handle(MultiSourceScraperService $scraper): int
    {
        $limit = (int) $this->option('limit');

        $jobs = JobListing::query()
            ->whereNull('salary_min')
            ->whereNull('salary_max')
            ->where('scraped_at', '>=', now()->subDays(7))
            ->limit($limit)
            ->get();

        if ($jobs->isEmpty()) {
            $this->info('Aucune offre à enrichir.');
            return Command::SUCCESS;
        }

        $this->info("Enrichissement de {$jobs->count()} offres...");
        $enriched = 0;

        foreach ($jobs as $job) {
            if ($scraper->enrichWithSalary($job)) {
                $enriched++;
            }
            usleep(500000); // 500 ms — respecter le rate limit du plan gratuit
        }

        $this->info("Terminé. {$enriched}/{$jobs->count()} offres enrichies avec des données salariales.");
        return Command::SUCCESS;
    }
}
