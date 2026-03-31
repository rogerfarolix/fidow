<?php
// app/Http/Controllers/StatsController.php

namespace App\Http\Controllers;

use App\Models\PositioningGeneration;
use App\Models\ToolUsage;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // Total usages par outil
        $usagesByTool = ToolUsage::select('tool_slug', DB::raw('count(*) as total'))
            ->groupBy('tool_slug')
            ->orderByDesc('total')
            ->get();

        // Usages par jour (30 derniers jours)
        $usagesPerDay = ToolUsage::select(
                DB::raw("DATE(created_at) as day"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Total générations de positionnement
        $totalGenerations = PositioningGeneration::count();

        // IP uniques = "utilisateurs" approx
        $uniqueUsers = ToolUsage::distinct('ip_address')->count('ip_address');

        // Métiers les plus fréquents
        $topMetiers = PositioningGeneration::select('metier', DB::raw('count(*) as total'))
            ->groupBy('metier')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Tonnes les plus utilisés
        $topTons = PositioningGeneration::select('ton', DB::raw('count(*) as total'))
            ->whereNotNull('ton')
            ->groupBy('ton')
            ->orderByDesc('total')
            ->get();

        // Phrases retenues (taux de rétention)
        $withRetained = PositioningGeneration::whereNotNull('phrase_retenue')->count();
        $retentionRate = $totalGenerations > 0
            ? round(($withRetained / $totalGenerations) * 100, 1)
            : 0;

        return view('accueil.stats', compact(
            'usagesByTool', 'usagesPerDay', 'totalGenerations',
            'uniqueUsers', 'topMetiers', 'topTons', 'retentionRate', 'withRetained'
        ));
    }
}
