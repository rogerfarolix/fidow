@extends('layouts.app')

@section('title', 'Génération #' . $generation->id . ' — Admin Fidow')

@section('content')
<div class="admin-page">

    <div class="admin-header">
        <div class="admin-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.data') }}">Générations</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
            <span>#{{ $generation->id }}</span>
        </div>
        
        <div class="admin-title">
            <h1>Détail de la génération</h1>
            <div class="admin-meta">
                <div class="admin-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    {{ $generation->created_at->format('d/m/Y à H:i') }}
                </div>
                <div class="admin-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $generation->ip_address }}
                </div>
                @if($generation->phrase_retenue)
                    <div class="admin-badge admin-badge--success">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                        Phrase retenue
                    </div>
                @else
                    <div class="admin-badge admin-badge--muted">Non retenue</div>
                @endif
            </div>
        </div>
    </div>

    <div class="admin-content">
        
        <!-- Profil utilisateur -->
        <div class="admin-card">
            <div class="admin-card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#872323" stroke-width="2"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                <h2>Profil utilisateur</h2>
            </div>
            
            <div class="admin-grid">
                <div class="admin-field">
                    <label>Métier</label>
                    <div class="admin-value">{{ $generation->metier ?: '—' }}</div>
                </div>
                <div class="admin-field">
                    <label>Niveau</label>
                    <div class="admin-value">{{ $generation->niveau ?: '—' }}</div>
                </div>
                @if($generation->techno)
                <div class="admin-field admin-field--full">
                    <label>Technologies</label>
                    <div class="admin-value">{{ $generation->techno }}</div>
                </div>
                @endif
                <div class="admin-field">
                    <label>Cible</label>
                    <div class="admin-value">{{ $generation->cible ?: '—' }}</div>
                </div>
                <div class="admin-field">
                    <label>Ton choisi</label>
                    <div class="admin-value">{{ $generation->ton ?: '—' }}</div>
                </div>
                <div class="admin-field admin-field--full">
                    <label>Résultat apporté</label>
                    <div class="admin-value">{{ $generation->resultat ?: '—' }}</div>
                </div>
                @if($generation->approche)
                <div class="admin-field">
                    <label>Approche</label>
                    <div class="admin-value">{{ $generation->approche }}</div>
                </div>
                @endif
                @if($generation->extra)
                <div class="admin-field">
                    <label>Infos complémentaires</label>
                    <div class="admin-value">{{ $generation->extra }}</div>
                </div>
                @endif
                <div class="admin-field">
                    <label>Usages prévus</label>
                    <div class="admin-value">{{ $generation->usages ?: '—' }}</div>
                </div>
                <div class="admin-field">
                    <label>Longueur demandée</label>
                    <div class="admin-value">{{ ['Courte', 'Équilibrée', 'Détaillée'][$generation->longueur - 1] ?? '—' }}</div>
                </div>
            </div>
        </div>

        <!-- Phrases générées -->
        <div class="admin-card">
            <div class="admin-card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#872323" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                <h2>Phrases générées</h2>
            </div>
            
            <div class="phrases-section">
                <div class="phrase-label">Phrase principale</div>
                <div class="phrase-block phrase-block--main">{{ $generation->phrase_1 ?: '—' }}</div>

                @if($generation->phrase_2)
                <div class="phrase-label">Variante 2</div>
                <div class="phrase-block phrase-block--alt">{{ $generation->phrase_2 }}</div>
                @endif

                @if($generation->phrase_3)
                <div class="phrase-label">Variante 3</div>
                <div class="phrase-block phrase-block--alt">{{ $generation->phrase_3 }}</div>
                @endif

                @if($generation->phrase_retenue)
                <div class="phrase-retained-section">
                    <div class="phrase-label phrase-label--success">✓ Phrase retenue par l'utilisateur</div>
                    <div class="phrase-block phrase-block--retained">{{ $generation->phrase_retenue }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Conseils générés -->
        @if($generation->tip_linkedin || $generation->tip_portfolio || $generation->tip_freelance || $generation->tip_candidature)
        <div class="admin-card">
            <div class="admin-card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e8a030" stroke-width="2"><path d="M9 11l3 3L22 4"/></svg>
                <h2>Conseils générés</h2>
            </div>
            
            <div class="tips-grid">
                @if($generation->tip_linkedin)
                <div class="tip-item">
                    <div class="tip-label">LinkedIn</div>
                    <div class="tip-content">{{ $generation->tip_linkedin }}</div>
                </div>
                @endif
                @if($generation->tip_portfolio)
                <div class="tip-item">
                    <div class="tip-label">Portfolio</div>
                    <div class="tip-content">{{ $generation->tip_portfolio }}</div>
                </div>
                @endif
                @if($generation->tip_freelance)
                <div class="tip-item">
                    <div class="tip-label">Malt / Upwork</div>
                    <div class="tip-content">{{ $generation->tip_freelance }}</div>
                </div>
                @endif
                @if($generation->tip_candidature)
                <div class="tip-item">
                    <div class="tip-label">Candidature</div>
                    <div class="tip-content">{{ $generation->tip_candidature }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Données techniques -->
        <div class="admin-card">
            <div class="admin-card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                <h2>Données techniques</h2>
            </div>
            
            <div class="admin-grid">
                <div class="admin-field">
                    <label>ID</label>
                    <div class="admin-value admin-value--mono">{{ $generation->id }}</div>
                </div>
                <div class="admin-field">
                    <label>Créé le</label>
                    <div class="admin-value">{{ $generation->created_at->format('d/m/Y H:i:s') }}</div>
                </div>
                <div class="admin-field">
                    <label>Adresse IP</label>
                    <div class="admin-value admin-value--mono">{{ $generation->ip_address }}</div>
                </div>
                @if($generation->user_agent)
                <div class="admin-field admin-field--full">
                    <label>User Agent</label>
                    <div class="admin-value admin-value--mono admin-value--small">{{ $generation->user_agent }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="admin-actions">
            <a href="{{ route('admin.data') }}" class="admin-btn admin-btn--secondary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Retour à la liste
            </a>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
/* ═════════════════════════════════════════════════════
   DÉTAIL GÉNÉRATION — thème Fidow cohérent
   Teintes douces · bordures légères · ombres douces
═════════════════════════════════════════════════════ */
:root {
    --fr:    #872323;
    --frd:   #6b1c1c;
    --bg-body: #fef7f7;
    --bg-white: #ffffff;
    --text-1: #111;
    --text-2: #374151;
    --text-3: #6b7280;
    --text-4: #9ca3af;
    --border: rgba(0,0,0,.07);
    --shadow-s: 0 2px 12px rgba(0,0,0,.04);
    --shadow-m: 0 8px 28px rgba(0,0,0,.06);
    --radius-m: 16px;
}

body {
    background-color: var(--bg-body);
    font-family: 'Inter', system-ui, sans-serif;
}

.admin-page {
    min-height: 100vh;
    background: var(--bg-body);
    padding: 2rem clamp(1rem, 4vw, 2rem);
    color: var(--text-2);
}

/* En-tête */
.admin-header {
    max-width: 1200px;
    margin: 0 auto 2rem;
}

.admin-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: var(--text-4);
    margin-bottom: 1rem;
}
.admin-breadcrumb a {
    color: var(--text-3);
    text-decoration: none;
    transition: color 0.2s;
}
.admin-breadcrumb a:hover { color: var(--fr); }
.admin-breadcrumb span {
    color: var(--fr);
    font-weight: 600;
}

.admin-title h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800;
    color: var(--text-1);
    margin-bottom: 0.75rem;
    letter-spacing: -0.02em;
}

.admin-meta {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.admin-meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    color: var(--text-3);
}

/* Badges */
.admin-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.admin-badge--success {
    background: rgba(16,185,129,.08);
    color: #059669;
    border: 1px solid rgba(16,185,129,.15);
}
.admin-badge--muted {
    background: var(--border);
    color: var(--text-3);
    border: 1px solid var(--border);
}

/* Cartes */
.admin-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.admin-card {
    background: var(--bg-white);
    border: 1px solid var(--border);
    border-radius: var(--radius-m);
    padding: 1.5rem;
    box-shadow: var(--shadow-s);
}

.admin-card-header {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(135,35,35,.08);
}
.admin-card-header h2 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-1);
    letter-spacing: -0.01em;
}

/* Grille des champs */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.admin-field {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.admin-field--full {
    grid-column: 1 / -1;
}

.admin-field label {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--text-4);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.admin-value {
    font-size: 0.88rem;
    color: var(--text-1);
    line-height: 1.5;
    word-break: break-word;
}

.admin-value--mono {
    font-family: 'SF Mono', 'Monaco', 'Inconsolata', 'Roboto Mono', monospace;
    font-size: 0.8rem;
    color: var(--fr);
}

.admin-value--small {
    font-size: 0.72rem;
}

/* Phrases */
.phrases-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.phrase-label {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--text-4);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.3rem;
}

.phrase-label--success {
    color: #059669;
}

.phrase-block {
    padding: 1rem 1.25rem;
    border-radius: 0.75rem;
    font-size: 0.92rem;
    line-height: 1.6;
    color: var(--text-1);
    border-left: 3px solid;
    background: #fff;
}

.phrase-block--main {
    background: rgba(135,35,35,.03);
    border-left-color: var(--fr);
}

.phrase-block--alt {
    background: #fafafa;
    border-left-color: #d1d5db;
}

.phrase-block--retained {
    background: rgba(16,185,129,.04);
    border-left-color: #059669;
}

.phrase-retained-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(135,35,35,.05);
}

/* Conseils */
.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1rem;
}

.tip-item {
    background: var(--bg-body);
    border: 1px solid var(--border);
    border-radius: 0.75rem;
    padding: 1rem;
}

.tip-label {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--text-4);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.4rem;
}

.tip-content {
    font-size: 0.85rem;
    color: var(--text-2);
    line-height: 1.5;
}

/* Boutons */
.admin-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    margin-top: 0.5rem;
}

.admin-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.4rem;
    border-radius: 0.6rem;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.admin-btn--secondary {
    background: var(--bg-white);
    color: var(--text-2);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-s);
}
.admin-btn--secondary:hover {
    background: #fff5f5;
    color: var(--fr);
    border-color: rgba(135,35,35,.2);
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 640px) {
    .admin-page { padding: 1.5rem 1rem; }
    .admin-grid { grid-template-columns: 1fr; }
    .tips-grid { grid-template-columns: 1fr; }
    .admin-meta { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    .admin-title h1 { font-size: 1.5rem; }
    .admin-card { padding: 1.25rem; }
}
</style>
@endpush