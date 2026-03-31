<?php
// app/Http/Controllers/AccueilController.php

namespace App\Http\Controllers;

use App\Models\ToolUsage;
use App\Models\PositioningGeneration;

class AccueilController extends Controller
{
    public function index()
    {
        $totalUsages      = ToolUsage::count();
        $totalGenerations = PositioningGeneration::count();

        return view('accueil.index', compact('totalUsages', 'totalGenerations'));
    }
}
