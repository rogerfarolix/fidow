<?php
// app/Http/Controllers/AccueilController.php

namespace App\Http\Controllers;

use App\Models\ToolUsage;
use App\Models\PositioningGeneration;
use App\Models\Avis;
use App\Models\User;

class AccueilController extends Controller
{
    public function index()
    {
        $totalUsages      = ToolUsage::count();
        $totalGenerations = PositioningGeneration::count();
        
        // Données des avis
        $totalAvis = Avis::approved()->count();
        $moyenneNote = Avis::approved()->avg('note') ?? 0;
        $recentAvis = Avis::approved()->latest()->take(3)->get();
        
        // Statistiques supplémentaires
        $totalUsers = User::count();
        $phrasesRetenues = PositioningGeneration::whereNotNull('phrase_retenue')->count();
        $metiersDistincts = PositioningGeneration::distinct('metier')->count('metier');

        return view('accueil.index', compact(
            'totalUsages', 
            'totalGenerations', 
            'totalAvis', 
            'moyenneNote', 
            'recentAvis',
            'totalUsers',
            'phrasesRetenues',
            'metiersDistincts'
        ));
    }
}
