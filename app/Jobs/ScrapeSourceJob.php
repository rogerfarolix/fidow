<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\MultiSourceScraperService;
use Illuminate\Support\Facades\Log;

class ScrapeSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $source;

    /**
     * Le nombre maximum de tentatives pour ce job.
     */
    public int $tries = 3;

    /**
     * Le nombre de secondes à attendre avant de réessayer.
     */
    public int $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(string $source)
    {
        $this->source = $source;
    }

    /**
     * Execute the job.
     */
    public function handle(MultiSourceScraperService $scraper): void
    {
        Log::info("[ScrapeSourceJob] Début du scraping pour la source : {$this->source}");
        
        try {
            $scraper->scrapeSingleSource($this->source);
            Log::info("[ScrapeSourceJob] Fin du scraping pour la source : {$this->source}");
        } catch (\Exception $e) {
            Log::error("[ScrapeSourceJob] Erreur sur {$this->source} : " . $e->getMessage());
            // Relancer l'exception pour que le job soit marqué en échec et réessayé
            throw $e;
        }
    }
}
