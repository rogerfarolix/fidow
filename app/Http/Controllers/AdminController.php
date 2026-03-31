<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\PositioningGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) return redirect()->route('admin.data');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->route('admin.data');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function data(Request $request)
    {
        $query = PositioningGeneration::latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('metier', 'ilike', "%{$search}%")
                  ->orWhere('cible', 'ilike', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($metier = $request->get('metier')) {
            $query->where('metier', $metier);
        }

        $generations = $query->paginate(25)->withQueryString();

        $allMetiers = PositioningGeneration::select('metier')
            ->distinct()->orderBy('metier')->pluck('metier');

        return view('admin.data', compact('generations', 'allMetiers'));
    }

    public function show(string $id)
    {
        $generation = PositioningGeneration::findOrFail($id);
        return view('admin.show', compact('generation'));
    }
}
