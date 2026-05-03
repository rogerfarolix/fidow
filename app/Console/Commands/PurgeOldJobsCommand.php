<?php

namespace App\Console\Commands;

use App\Models\JobListing;
use App\Models\SentJobLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurgeOldJobsCommand extends Command
{
    protected $signature   = 'digest:purge {--dry-run : Affiche ce qui serait supprimé sans supprimer}';
    protected $description = 'Supprime les offres expirées (> 14 jours) et les logs d\'envoi associés';

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');

        $this->info($isDryRun ? '🔍 Mode dry-run (aucune suppression)...' : '🧹 Purge des offres expirées...');

        // Compter les offres expirées
        $expiredCount = JobListing::expired()->count();
        $logCount     = SentJobLog::whereIn(
            'job_listing_id',
            JobListing::expired()->select('id')
        )->count();

        $this->table(
            ['À supprimer', 'Nombre'],
            [
                ['Offres expirées',         $expiredCount],
                ['Logs d\'envoi associés',  $logCount],
            ]
        );

        if ($expiredCount === 0) {
            $this->info('✅ Aucune offre expirée. Rien à faire.');
            return Command::SUCCESS;
        }

        if ($isDryRun) {
            $this->warn('Dry-run : aucune suppression effectuée.');
            return Command::SUCCESS;
        }

        // En mode non-interactif (scheduler), on confirme automatiquement
        if ($this->input->isInteractive() && !$this->confirm("Supprimer {$expiredCount} offre(s) et {$logCount} log(s) ?", true)) {
            $this->info('Annulé.');
            return Command::SUCCESS;
        }

        try {
            DB::transaction(function () use ($expiredCount) {
                // Les sent_job_logs sont supprimés en cascade via FK
                JobListing::expired()->delete();
            });

            $this->info("✅ Purge terminée : {$expiredCount} offre(s) supprimée(s), {$logCount} log(s) associé(s).");

            Log::info('[DigestPurge] Purge terminée', [
                'jobs_deleted' => $expiredCount,
                'logs_deleted' => $logCount,
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Erreur : ' . $e->getMessage());
            Log::error('[DigestPurge] Erreur', ['message' => $e->getMessage()]);
            return Command::FAILURE;
        }
    }
}
