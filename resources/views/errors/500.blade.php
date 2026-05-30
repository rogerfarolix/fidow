@extends('layouts.app')
@section('title', '500 — Erreur serveur · Fidow')
@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:3rem 1.5rem;text-align:center;">
    <div style="max-width:480px;width:100%;">
        <div style="width:72px;height:72px;border-radius:50%;background:rgba(135,35,35,.15);border:1px solid rgba(135,35,35,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <svg width="32" height="32" fill="none" stroke="#f87171" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div style="font-family:'Space Grotesk',sans-serif;font-size:5rem;font-weight:900;line-height:1;color:#f3f4f6;margin-bottom:.5rem;">500</div>
        <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem;font-weight:700;color:#f3f4f6;margin-bottom:.75rem;">Erreur serveur</h1>
        <p style="color:#9ca3af;font-size:.95rem;line-height:1.7;margin-bottom:2rem;">
            Une erreur inattendue s'est produite. L'équipe a été notifiée.
        </p>
        <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-bottom:2.5rem;">
            <button onclick="location.reload()" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:#872323;color:#fff;border:none;border-radius:12px;font-weight:700;font-size:.875rem;cursor:pointer;box-shadow:0 4px 16px rgba(135,35,35,.35);"
                    onmouseover="this.style.background='#6b1c1c'" onmouseout="this.style.background='#872323'">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
                Réessayer
            </button>
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:rgba(255,255,255,.06);color:#d1d5db;border:1px solid rgba(255,255,255,.1);border-radius:12px;font-weight:600;font-size:.875rem;text-decoration:none;"
               onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.06)'">
                Retour à l'accueil
            </a>
        </div>
        <div style="background:#161619;border:1px solid rgba(245,158,11,.2);border-radius:16px;padding:1.25rem;text-align:left;">
            <p style="font-size:.8rem;font-weight:700;color:#d97706;margin-bottom:.6rem;">Que faire ?</p>
            <ul style="font-size:.8rem;color:#9ca3af;line-height:1.8;padding:0;margin:0;list-style:none;">
                <li style="display:flex;align-items:center;gap:.4rem;"><svg width="10" height="10" fill="none" stroke="#6b7280" viewBox="0 0 24 24" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>Réessaie dans quelques instants</li>
                <li style="display:flex;align-items:center;gap:.4rem;"><svg width="10" height="10" fill="none" stroke="#6b7280" viewBox="0 0 24 24" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>Vérifie ta connexion internet</li>
                <li style="display:flex;align-items:center;gap:.4rem;"><svg width="10" height="10" fill="none" stroke="#6b7280" viewBox="0 0 24 24" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>Si le problème persiste, contacte l'équipe</li>
            </ul>
        </div>
        @if(config('app.debug'))
        <div style="margin-top:1rem;padding:.75rem 1rem;background:#0a0a0d;border:1px solid rgba(255,255,255,.06);border-radius:10px;font-family:monospace;font-size:.72rem;color:#6b7280;text-align:left;">
            Error ID: {{ uniqid() }} · {{ now()->format('Y-m-d H:i:s') }}
        </div>
        @endif
    </div>
</div>
@endsection
