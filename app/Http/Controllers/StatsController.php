<?php
// app/Http/Controllers/StatsController.php

namespace App\Http\Controllers;

use App\Models\DigestSubscriber;
use App\Models\JobListing;
use App\Models\PositioningGeneration;
use App\Models\SentJobLog;
use App\Models\ToolUsage;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // ── Positionnement Pro ────────────────────────────────────────────────

        $usagesByTool = ToolUsage::select('tool_slug', DB::raw('count(*) as total'))
            ->groupBy('tool_slug')
            ->orderByDesc('total')
            ->get();

        $usagesPerDay = ToolUsage::select(
                DB::raw("DATE(created_at) as day"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $totalGenerations = PositioningGeneration::count();
        $uniqueUsers      = ToolUsage::distinct('ip_address')->count('ip_address');

        $topMetiers = PositioningGeneration::select('metier', DB::raw('count(*) as total'))
            ->groupBy('metier')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topTons = PositioningGeneration::select('ton', DB::raw('count(*) as total'))
            ->whereNotNull('ton')
            ->groupBy('ton')
            ->orderByDesc('total')
            ->get();

        $withRetained  = PositioningGeneration::whereNotNull('phrase_retenue')->count();
        $retentionRate = $totalGenerations > 0
            ? round(($withRetained / $totalGenerations) * 100, 1)
            : 0;

        // ── RemoteDigest ──────────────────────────────────────────────────────

        // KPIs globaux
        $digestSubscribers     = DigestSubscriber::actif()->count();
        $digestJobsInBase      = JobListing::active()->count();
        $digestEmailsSent      = SentJobLog::count();
        $digestJobsByDomain    = JobListing::active()
            ->select('domain', DB::raw('count(*) as total'))
            ->groupBy('domain')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // Sources scrapées
        $digestBySource = JobListing::active()
            ->select('source', DB::raw('count(*) as total'))
            ->groupBy('source')
            ->orderByDesc('total')
            ->get();

        // Abonnés par domaine
        $digestSubscribersByDomain = DigestSubscriber::actif()
            ->select('domain', DB::raw('count(*) as total'))
            ->groupBy('domain')
            ->orderByDesc('total')
            ->get();

        // Inscriptions des 30 derniers jours
        $digestGrowth = DigestSubscriber::select(
                DB::raw("DATE(created_at) as day"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('accueil.stats', compact(
            // Positionnement Pro
            'usagesByTool', 'usagesPerDay', 'totalGenerations',
            'uniqueUsers', 'topMetiers', 'topTons', 'retentionRate', 'withRetained',
            // RemoteDigest
            'digestSubscribers', 'digestJobsInBase', 'digestEmailsSent',
            'digestJobsByDomain', 'digestBySource', 'digestSubscribersByDomain', 'digestGrowth'
        ));
    }
}
