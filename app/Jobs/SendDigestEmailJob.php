<?php

namespace App\Jobs;

use App\Mail\DigestMail;
use App\Models\DigestSubscriber;
use App\Models\SentJobLog;
use App\Services\JobMatchingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDigestEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** Nombre minimum d'offres nouvelles pour déclencher l'envoi */
    private const MIN_JOBS = 5;

    public int $tries   = 3;
    public int $timeout = 120;

    public function __construct(private DigestSubscriber $subscriber) {}

    public function handle(JobMatchingService $matcher): void
    {
        $subscriber = $this->subscriber;

        Log::info("[DigestJob] Traitement de {$subscriber->email}");

        // Sélectionner les 20 meilleures offres non encore envoyées
        $jobs = $matcher->getTopJobsForSubscriber($subscriber, 20);

        // Règle métier : pas d'envoi si moins de MIN_JOBS offres disponibles
        if ($jobs->count() < self::MIN_JOBS) {
            Log::info("[DigestJob] Skip {$subscriber->email} : seulement {$jobs->count()} offre(s) disponible(s) (min " . self::MIN_JOBS . ")");
            return;
        }

        // Envoyer l'email
        Mail::to($subscriber->email)->send(new DigestMail($subscriber, $jobs));

        // Enregistrer les offres envoyées (anti-doublon absolu)
        $now = now();
        $logs = $jobs->map(fn($job) => [
            'subscriber_id'  => $subscriber->id,
            'job_listing_id' => $job->id,
            'sent_at'        => $now,
        ])->toArray();

        // Insert-ignore : si doublon, on saute silencieusement
        foreach ($logs as $log) {
            try {
                SentJobLog::insert($log);
            } catch (\Exception $e) {
                // Doublon en BDD : déjà envoyé, on continue
                Log::debug("[DigestJob] Doublon ignoré pour job {$log['job_listing_id']}");
            }
        }

        Log::info("[DigestJob] ✅ Digest envoyé à {$subscriber->email}", [
            'jobs_sent' => $jobs->count(),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("[DigestJob] ❌ Échec pour {$this->subscriber->email}", [
            'error' => $exception->getMessage(),
        ]);
    }
}
