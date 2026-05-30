@extends('layouts.app')
@section('title', '404 — Page non trouvée · Fidow')
@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:3rem 1.5rem;text-align:center;">
    <div style="max-width:480px;width:100%;">
        <div style="width:72px;height:72px;border-radius:50%;background:rgba(135,35,35,.15);border:1px solid rgba(135,35,35,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <svg width="32" height="32" fill="none" stroke="#f87171" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div style="font-family:'Space Grotesk',sans-serif;font-size:5rem;font-weight:900;line-height:1;color:#f3f4f6;margin-bottom:.5rem;">404</div>
        <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.5rem;font-weight:700;color:#f3f4f6;margin-bottom:.75rem;">Page non trouvée</h1>
        <p style="color:#9ca3af;font-size:.95rem;line-height:1.7;margin-bottom:2rem;">
            La page que tu cherches n'existe pas ou a été déplacée.
        </p>
        <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-bottom:2.5rem;">
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:#872323;color:#fff;border-radius:12px;font-weight:700;font-size:.875rem;text-decoration:none;transition:all .2s;box-shadow:0 4px 16px rgba(135,35,35,.35);"
               onmouseover="this.style.background='#6b1c1c'" onmouseout="this.style.background='#872323'">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Retour à l'accueil
            </a>
            <button onclick="history.back()" style="padding:.75rem 1.5rem;background:rgba(255,255,255,.06);color:#d1d5db;border:1px solid rgba(255,255,255,.1);border-radius:12px;font-weight:600;font-size:.875rem;cursor:pointer;"
                    onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.06)'">
                Retour en arrière
            </button>
        </div>
        <div style="background:#161619;border:1px solid rgba(255,255,255,.07);border-radius:16px;padding:1.25rem;">
            <p style="font-size:.75rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#6b7280;margin-bottom:.75rem;">Liens utiles</p>
            <div style="display:flex;flex-direction:column;gap:.35rem;">
                <a href="{{ route('positionnement') }}" style="color:#f87171;font-size:.85rem;text-decoration:none;display:flex;align-items:center;gap:.35rem;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Générateur de positionnement
                </a>
                <a href="{{ route('tjm.index') }}" style="color:#f87171;font-size:.85rem;text-decoration:none;display:flex;align-items:center;gap:.35rem;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Simulateur TJM
                </a>
                <a href="{{ route('linkedin.analyse') }}" style="color:#f87171;font-size:.85rem;text-decoration:none;display:flex;align-items:center;gap:.35rem;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Analyse LinkedIn
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
