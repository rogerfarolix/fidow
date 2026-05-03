<?php

namespace App\Http\Controllers;

use App\Models\DigestSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DigestController extends Controller
{
    /** Page principale — formulaire d'inscription */
    public function index()
    {
        $stats = [
            'subscribers' => DigestSubscriber::actif()->count(),
        ];
        return view('digest.index', compact('stats'));
    }

    /** Enregistrement d'un abonné */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email'                    => 'required|email|max:120',
            'domain'                   => 'required|in:dev,design,marketing,cyber,data,product,other',
            'metier'                   => 'required|string|min:2|max:120',
            'preferences.type_contrat' => 'nullable|in:full_time,part_time,freelance,contract',
            'preferences.niveau'       => 'nullable|in:junior,mid,senior,expert',
            'preferences.pays'         => 'nullable|string|max:80',
            'preferences.salaire_min'  => 'nullable|integer|min:0|max:500000',
            'send_hour'                => 'nullable|integer|min:0|max:23',
            'timezone'                 => 'nullable|string|max:60',
        ]);

        // Si déjà inscrit, on met juste à jour les préférences
        $subscriber = DigestSubscriber::where('email', $validated['email'])->first();

        if ($subscriber) {
            $subscriber->update([
                'domain'      => $validated['domain'],
                'metier'      => $validated['metier'],
                'preferences' => $validated['preferences'] ?? null,
                'send_hour'   => $validated['send_hour'] ?? 19,
                'timezone'    => $validated['timezone'] ?? 'Africa/Porto-Novo',
                'actif'       => true,
            ]);

            Log::info('[Digest] Préférences mises à jour', ['email' => $validated['email']]);
            return back()->with('success', 'Tes préférences ont été mises à jour ! Tu recevras ton digest ce soir. 🎉');
        }

        // Nouvel abonné
        DigestSubscriber::create([
            'id'                => \Illuminate\Support\Str::uuid(),
            'email'             => $validated['email'],
            'domain'            => $validated['domain'],
            'metier'            => $validated['metier'],
            'preferences'       => $validated['preferences'] ?? null,
            'send_hour'         => $validated['send_hour'] ?? 19,
            'timezone'          => $validated['timezone'] ?? 'Africa/Porto-Novo',
            'actif'             => true,
            'unsubscribe_token' => DigestSubscriber::generateUnsubscribeToken(),
            'confirmed_at'      => now(),
        ]);

        Log::info('[Digest] Nouveau subscriber', ['email' => $validated['email']]);

        return back()->with('success', 'Inscription réussie ! 🎉 Tu recevras ton premier digest dès ce soir avec les meilleures offres remote correspondant à ton profil.');
    }

    /** Désabonnement 1 clic via token UUID */
    public function unsubscribe(string $token)
    {
        $subscriber = DigestSubscriber::where('unsubscribe_token', $token)->first();

        if (!$subscriber) {
            return view('digest.unsubscribe', ['status' => 'not_found']);
        }

        if (!$subscriber->actif) {
            return view('digest.unsubscribe', ['status' => 'already', 'email' => $subscriber->email]);
        }

        $subscriber->update(['actif' => false]);

        Log::info('[Digest] Désabonnement', ['email' => $subscriber->email]);

        return view('digest.unsubscribe', ['status' => 'done', 'email' => $subscriber->email]);
    }

    /** Afficher le formulaire de modification des préférences */
    public function preferences(string $token)
    {
        $subscriber = DigestSubscriber::where('unsubscribe_token', $token)->firstOrFail();
        return view('digest.preferences', compact('subscriber', 'token'));
    }

    /** Sauvegarder les préférences modifiées */
    public function updatePreferences(Request $request, string $token)
    {
        $subscriber = DigestSubscriber::where('unsubscribe_token', $token)->firstOrFail();

        $validated = $request->validate([
            'domain'                   => 'required|in:dev,design,marketing,cyber,data,product,other',
            'metier'                   => 'required|string|min:2|max:120',
            'preferences.type_contrat' => 'nullable|in:full_time,part_time,freelance,contract',
            'preferences.niveau'       => 'nullable|in:junior,mid,senior,expert',
            'preferences.pays'         => 'nullable|string|max:80',
            'preferences.salaire_min'  => 'nullable|integer|min:0|max:500000',
            'send_hour'                => 'nullable|integer|min:0|max:23',
            'actif'                    => 'nullable|boolean',
        ]);

        $subscriber->update([
            'domain'      => $validated['domain'],
            'metier'      => $validated['metier'],
            'preferences' => $validated['preferences'] ?? null,
            'send_hour'   => $validated['send_hour'] ?? $subscriber->send_hour,
            'actif'       => $validated['actif'] ?? $subscriber->actif,
        ]);

        return back()->with('success', 'Préférences sauvegardées ! Les changements seront appliqués dès ce soir. ✅');
    }
}
