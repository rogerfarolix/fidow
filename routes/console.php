<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ── RemoteDigest Scheduler ───────────────────────────────────────────────────
// 6h00 : Scraping de toutes les sources (best-effort)
Schedule::command('digest:scrape')->dailyAt('06:00')->withoutOverlapping();

// 18h30 : Envoi des digests (dispatche les jobs en queue)
Schedule::command('digest:send')->dailyAt('18:30')->withoutOverlapping();

// Tous les dimanches à 3h : purge des offres expirées (> 14 jours)
Schedule::command('digest:purge')->weekly()->sundays()->at('03:00')
         ->onSuccess(fn() => \Illuminate\Support\Facades\Log::info('[Scheduler] digest:purge OK'));
