@extends('layouts.app')
@section('title', 'Mes préférences — RemoteDigest Fidow')
@section('content')
<div style="min-height:100vh;background:var(--dm-bg-page,#fef7f7);padding:3rem 1rem;display:flex;align-items:flex-start;justify-content:center;">
    <div style="max-width:620px;width:100%;">

        <div style="text-align:center;margin-bottom:2rem;">
            <div style="display:inline-flex;align-items:center;gap:.5rem;padding:.42rem .9rem;border-radius:999px;background:rgba(135,35,35,.07);border:1px solid rgba(135,35,35,.14);color:#872323;font-size:.78rem;font-weight:700;margin-bottom:1rem;">
                📡 RemoteDigest
            </div>
            <h1 style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;letter-spacing:-.04em;color:var(--dm-text-1,#111);margin:0 0 .5rem;">Mes préférences</h1>
            <p style="color:var(--dm-text-3,#6b7280);font-size:.95rem;margin:0;">
                Modifie ton profil — les changements seront appliqués dès le prochain digest.
            </p>
        </div>

        @if(session('success'))
        <div style="display:flex;align-items:center;gap:.7rem;padding:1rem 1.25rem;border-radius:14px;margin-bottom:1.5rem;background:rgba(5,150,105,.07);border:1px solid rgba(5,150,105,.18);color:#059669;font-weight:600;font-size:.9rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <div style="background:var(--dm-bg-card,#fff);border:1px solid var(--dm-border,rgba(0,0,0,.07));border-radius:24px;padding:2rem;box-shadow:0 16px 48px rgba(0,0,0,.07);">

            <div style="display:flex;align-items:center;gap:.75rem;padding:.9rem 1.1rem;background:rgba(135,35,35,.04);border:1px solid rgba(135,35,35,.1);border-radius:12px;margin-bottom:1.75rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#872323" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                <span style="font-size:.85rem;color:var(--dm-text-2,#374151);">Abonné : <strong>{{ $subscriber->email }}</strong></span>
            </div>

            <form action="{{ route('digest.preferences.update', $token) }}" method="POST"
                  style="display:flex;flex-direction:column;gap:1.2rem;">
                @csrf
                @method('POST')

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div style="display:flex;flex-direction:column;gap:.45rem;">
                        <label style="font-size:.83rem;font-weight:800;color:var(--dm-text-2,#374151);">Domaine *</label>
                        <select name="domain" required
                                style="width:100%;padding:.85rem 1rem;border:1.5px solid rgba(0,0,0,.1);border-radius:12px;font-size:.9rem;background:var(--dm-bg-soft,#fafafa);color:var(--dm-text-1,#111);outline:none;font-family:inherit;">
                            @foreach(['dev'=>'Développement','design'=>'Design / UX-UI','marketing'=>'Marketing Digital','cyber'=>'Cybersécurité','data'=>'Data / IA','product'=>'Product Management','other'=>'Autre'] as $val => $lbl)
                            <option value="{{ $val }}" {{ $subscriber->domain === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:.45rem;">
                        <label style="font-size:.83rem;font-weight:800;color:var(--dm-text-2,#374151);">Métier précis *</label>
                        <input type="text" name="metier" required value="{{ $subscriber->metier }}"
                               style="width:100%;padding:.85rem 1rem;border:1.5px solid rgba(0,0,0,.1);border-radius:12px;font-size:.9rem;background:var(--dm-bg-soft,#fafafa);color:var(--dm-text-1,#111);outline:none;font-family:inherit;box-sizing:border-box;">
                    </div>
                </div>

                @php $prefs = $subscriber->preferences_with_defaults; @endphp

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div style="display:flex;flex-direction:column;gap:.45rem;">
                        <label style="font-size:.83rem;font-weight:800;color:var(--dm-text-2,#374151);">Type de contrat</label>
                        <select name="preferences[type_contrat]"
                                style="width:100%;padding:.85rem 1rem;border:1.5px solid rgba(0,0,0,.1);border-radius:12px;font-size:.9rem;background:var(--dm-bg-soft,#fafafa);color:var(--dm-text-1,#111);outline:none;font-family:inherit;">
                            <option value="">Tous types</option>
                            @foreach(['full_time'=>'CDI / Full-time','freelance'=>'Freelance / Mission','part_time'=>'Temps partiel','contract'=>'CDD / Contrat'] as $val => $lbl)
                            <option value="{{ $val }}" {{ ($prefs['type_contrat']??'') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:.45rem;">
                        <label style="font-size:.83rem;font-weight:800;color:var(--dm-text-2,#374151);">Niveau</label>
                        <select name="preferences[niveau]"
                                style="width:100%;padding:.85rem 1rem;border:1.5px solid rgba(0,0,0,.1);border-radius:12px;font-size:.9rem;background:var(--dm-bg-soft,#fafafa);color:var(--dm-text-1,#111);outline:none;font-family:inherit;">
                            <option value="">Tous niveaux</option>
                            @foreach(['junior'=>'Junior','mid'=>'Intermédiaire','senior'=>'Senior','expert'=>'Expert'] as $val => $lbl)
                            <option value="{{ $val }}" {{ ($prefs['niveau']??'') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div style="display:flex;flex-direction:column;gap:.45rem;">
                        <label style="font-size:.83rem;font-weight:800;color:var(--dm-text-2,#374151);">Pays préféré</label>
                        <input type="text" name="preferences[pays]" value="{{ $prefs['pays'] ?? '' }}"
                               placeholder="Ex : France, Worldwide"
                               style="width:100%;padding:.85rem 1rem;border:1.5px solid rgba(0,0,0,.1);border-radius:12px;font-size:.9rem;background:var(--dm-bg-soft,#fafafa);color:var(--dm-text-1,#111);outline:none;font-family:inherit;box-sizing:border-box;">
                    </div>
                    <div style="display:flex;flex-direction:column;gap:.45rem;">
                        <label style="font-size:.83rem;font-weight:800;color:var(--dm-text-2,#374151);">Heure de réception</label>
                        <select name="send_hour"
                                style="width:100%;padding:.85rem 1rem;border:1.5px solid rgba(0,0,0,.1);border-radius:12px;font-size:.9rem;background:var(--dm-bg-soft,#fafafa);color:var(--dm-text-1,#111);outline:none;font-family:inherit;">
                            @for($h = 6; $h <= 22; $h++)
                            <option value="{{ $h }}" {{ $subscriber->send_hour === $h ? 'selected' : '' }}>{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:00</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:.6rem;padding:1rem;background:rgba(135,35,35,.03);border:1px solid rgba(135,35,35,.08);border-radius:12px;">
                    <input type="checkbox" name="actif" value="1" id="actif" {{ $subscriber->actif ? 'checked' : '' }}
                           style="width:18px;height:18px;accent-color:#872323;cursor:pointer;">
                    <label for="actif" style="font-size:.9rem;font-weight:700;color:var(--dm-text-2,#374151);cursor:pointer;">
                        Recevoir le digest quotidien (décocher = pause sans désabonnement)
                    </label>
                </div>

                <button type="submit"
                        style="display:flex;align-items:center;justify-content:center;gap:.65rem;padding:1rem 1.75rem;background:#872323;color:#fff;border:none;border-radius:14px;font-size:.95rem;font-weight:800;cursor:pointer;box-shadow:0 8px 28px rgba(135,35,35,.25);font-family:inherit;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Sauvegarder mes préférences
                </button>
            </form>
        </div>

        <div style="text-align:center;margin-top:1.5rem;">
            <a href="{{ route('digest.unsubscribe', $token) }}"
               style="font-size:.82rem;color:#9ca3af;text-decoration:underline;">
                Se désabonner définitivement
            </a>
        </div>
    </div>
</div>
@endsection
