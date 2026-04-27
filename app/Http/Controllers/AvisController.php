<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avis;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    public function index()
    {
        $avis = Avis::approved()->latest()->paginate(10);
        return view('avis.index', compact('avis'));
    }

    public function create()
    {
        return view('avis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'note' => 'required|integer|between:1,5',
            'commentaire' => 'required|string|min:10|max:2000',
        ]);

        $validated['statut'] = 'pending';
        
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        Avis::create($validated);

        return redirect()->route('avis.index')
            ->with('success', 'Votre avis a été soumis et sera visible après validation par l\'administrateur.');
    }

    public function adminIndex()
    {
        $avisPending = Avis::pending()->latest()->get();
        $avisApproved = Avis::approved()->latest()->paginate(20);
        
        return view('admin.avis.index', compact('avisPending', 'avisApproved'));
    }

    public function approve(Avis $avis)
    {
        $avis->update(['statut' => 'approved']);
        
        return redirect()->route('admin.avis.index')
            ->with('success', 'Avis approuvé avec succès.');
    }

    public function reject(Avis $avis)
    {
        $avis->delete();
        
        return redirect()->route('admin.avis.index')
            ->with('success', 'Avis rejeté et supprimé.');
    }
}
