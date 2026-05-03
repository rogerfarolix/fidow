<?php

namespace App\Console\Commands;

use App\Jobs\SendDigestEmailJob;
use App\Models\DigestSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendDailyDigestCommand extends Command
{
    protected $signature   = 'digest:send {--subscriber= : ID d\'un abonné spécifique pour test}';
    protected $description = 'Envoie le digest quotidien d\'offres remote à tous les abonnés actifs';

    public function handle(): int
    {
        $this->info('📬 Démarrage de l\'envoi du digest quotidien...');

        // Cible : un abonné spécifique (pour test) ou tous les actifs
        $subscriberId = $this->option('subscriber');

        $query = DigestSubscriber::actif();
        if ($subscriberId) {
            $query->where('id', $subscriberId);
        }

        $subscribers = $query->get();

        if ($subscribers->isEmpty()) {
            $this->warn('Aucun abonné actif trouvé.');
            return Command::SUCCESS;
        }

        $this->info("📋 {$subscribers->count()} abonné(s) à traiter...");
        $bar = $this->output->createProgressBar($subscribers->count());
        $bar->start();

        $dispatched = 0;

        foreach ($subscribers as $subscriber) {
            try {
                // Dispatch asynchrone via queue
                SendDigestEmailJob::dispatch($subscriber);
                $dispatched++;
            } catch (\Exception $e) {
                Log::error('[DigestSend] Erreur dispatch pour ' . $subscriber->email, [
                    'error' => $e->getMessage(),
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ {$dispatched} job(s) en queue. Les emails seront envoyés en arrière-plan.");

        Log::info('[DigestSend] Jobs dispatchés', [
            'total'      => $subscribers->count(),
            'dispatched' => $dispatched,
        ]);

        return Command::SUCCESS;
    }
}
