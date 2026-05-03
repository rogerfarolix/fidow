@extends('layouts.app')
@section('title', 'Désabonnement — RemoteDigest Fidow')
@section('content')
<div style="min-height:100vh;background:var(--dm-bg-page,#fef7f7);display:flex;align-items:center;justify-content:center;padding:2rem;">
    <div style="max-width:480px;width:100%;background:var(--dm-bg-card,#fff);border:1px solid var(--dm-border,rgba(0,0,0,.07));border-radius:28px;padding:3rem 2.5rem;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.08);">

        @if($status === 'done')
            <div style="width:72px;height:72px;border-radius:50%;background:rgba(5,150,105,.08);color:#059669;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.6rem;font-weight:800;color:var(--dm-text-1,#111);margin:0 0 .75rem;letter-spacing:-.03em;">Désabonnement effectué</h1>
            <p style="color:var(--dm-text-3,#6b7280);line-height:1.7;margin:0 0 2rem;font-size:.95rem;">
                <strong style="color:var(--dm-text-2,#374151);">{{ $email }}</strong> ne recevra plus de digest RemoteDigest.<br>
                Nous espérons avoir pu t'aider dans ta recherche d'opportunités remote. 🙏
            </p>
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:.6rem;padding:.9rem 1.75rem;background:#872323;color:#fff;border-radius:14px;font-weight:800;font-size:.95rem;text-decoration:none;">
                Retour à l'accueil
            </a>
            <div style="margin-top:1.5rem;">
                <a href="{{ route('digest.index') }}" style="font-size:.85rem;color:#9ca3af;text-decoration:underline;">
                    Se réabonner avec un autre profil
                </a>
            </div>

        @elseif($status === 'already')
            <div style="width:72px;height:72px;border-radius:50%;background:rgba(245,158,11,.08);color:#d97706;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.6rem;font-weight:800;color:var(--dm-text-1,#111);margin:0 0 .75rem;">Déjà désabonné</h1>
            <p style="color:var(--dm-text-3,#6b7280);line-height:1.7;margin:0 0 2rem;font-size:.95rem;">
                <strong style="color:var(--dm-text-2,#374151);">{{ $email }}</strong> est déjà désinscrit du RemoteDigest.
            </p>
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:.6rem;padding:.9rem 1.75rem;background:#872323;color:#fff;border-radius:14px;font-weight:800;font-size:.95rem;text-decoration:none;">
                Retour à l'accueil
            </a>

        @else
            <div style="width:72px;height:72px;border-radius:50%;background:rgba(220,38,38,.08);color:#dc2626;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <h1 style="font-family:'Space Grotesk',sans-serif;font-size:1.6rem;font-weight:800;color:var(--dm-text-1,#111);margin:0 0 .75rem;">Lien invalide</h1>
            <p style="color:var(--dm-text-3,#6b7280);line-height:1.7;margin:0 0 2rem;font-size:.95rem;">
                Ce lien de désabonnement est invalide ou a déjà été utilisé.
            </p>
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:.6rem;padding:.9rem 1.75rem;background:#872323;color:#fff;border-radius:14px;font-weight:800;font-size:.95rem;text-decoration:none;">
                Retour à l'accueil
            </a>
        @endif
    </div>
</div>
@endsection
