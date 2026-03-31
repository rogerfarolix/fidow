<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Génération #{{ $generation->id }} — Admin Fidow</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@700;800;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{--bg:#080606;--s1:#0f0a0a;--s2:#170e0e;--s3:#1f1414;--accent:#872323;--green:#2ef0a0;--gold:#e8a030;--text:#f4eded;--text2:#c8b8b8;--muted:#6b5757;--border:rgba(135,35,35,.2);--border2:rgba(255,255,255,.05)}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:grid;grid-template-columns:240px 1fr}

/* SIDEBAR */
.sidebar{background:var(--s1);border-right:1px solid var(--border);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
.sidebar-logo{padding:20px 18px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;flex-shrink:0}
.sidebar-logo img{height:28px}
.sidebar-logo-text{font-family:'Cabinet Grotesk',sans-serif;font-weight:900;font-size:16px;color:var(--text)}
.sidebar-badge{font-size:9px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;background:rgba(135,35,35,.15);border:1px solid rgba(135,35,35,.25);color:#d47070;border-radius:100px;padding:2px 8px}
.nav-section{padding:16px 14px 6px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)}
.nav-item{display:flex;align-items:center;gap:9px;padding:9px 14px;color:var(--muted);font-size:13px;font-weight:500;text-decoration:none;transition:all .18s;border-radius:9px;margin:1px 8px}
.nav-item:hover{color:var(--text);background:rgba(135,35,35,.1)}
.nav-item.active{color:var(--text);background:rgba(135,35,35,.14);border:1px solid rgba(135,35,35,.22)}
.sidebar-footer{margin-top:auto;padding:16px 10px;border-top:1px solid var(--border)}
.logout-btn{width:100%;padding:9px 14px;background:transparent;border:1px solid rgba(135,35,35,.2);border-radius:9px;color:var(--muted);font-size:13px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:8px;justify-content:center}
.logout-btn:hover{background:rgba(135,35,35,.1);color:#d47070;border-color:var(--accent)}

/* MAIN */
.main{overflow-y:auto;background:var(--bg)}
.main-inner{padding:36px 40px 80px;max-width:900px}

/* BREADCRUMB */
.breadcrumb{display:flex;align-items:center;gap:8px;margin-bottom:24px;font-size:13px;color:var(--muted)}
.breadcrumb a{color:var(--muted);text-decoration:none;transition:color .2s}
.breadcrumb a:hover{color:var(--text)}
.breadcrumb-sep{opacity:.4}

.page-title{font-family:'Cabinet Grotesk',sans-serif;font-size:24px;font-weight:900;letter-spacing:-.02em;margin-bottom:4px}
.page-meta{color:var(--muted);font-size:13px;margin-bottom:28px;display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.page-meta span{display:flex;align-items:center;gap:5px}

/* CARDS */
.card{background:var(--s1);border:1px solid var(--border);border-radius:16px;padding:24px;margin-bottom:16px}
.card-title{font-family:'Cabinet Grotesk',sans-serif;font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:14px;display:flex;align-items:center;gap:7px}

.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.info-item{background:var(--s2);border-radius:10px;padding:12px 14px}
.info-label{font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);margin-bottom:4px}
.info-value{font-size:13px;color:var(--text);line-height:1.4;word-break:break-word}
.info-value.mono{font-family:monospace;font-size:12px;color:var(--text2)}
.info-full{grid-column:1/-1}

/* PHRASES */
.phrase-block{padding:16px 18px;border-radius:11px;font-size:14px;line-height:1.6;color:var(--text);border-left:3px solid;margin-bottom:10px;position:relative}
.phrase-main-block{background:rgba(135,35,35,.06);border-left-color:var(--accent)}
.phrase-alt-block{background:var(--s2);border-left-color:rgba(255,255,255,.12)}
.phrase-label{font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:6px}
.phrase-retained{background:rgba(46,240,160,.05);border-left-color:var(--green)}

/* TIPS GRID */
.tips-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.tip-item{background:var(--s2);border-radius:10px;padding:13px 14px}
.tip-label{font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);margin-bottom:5px}
.tip-value{font-size:13px;color:var(--text2);line-height:1.5}

/* BADGE */
.badge{display:inline-flex;align-items:center;gap:5px;font-size:10px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;border-radius:100px;padding:3px 10px;border:1px solid}
.badge-green{background:rgba(46,240,160,.08);border-color:rgba(46,240,160,.22);color:var(--green)}
.badge-muted{background:var(--s2);border-color:var(--border2);color:var(--muted)}

/* NAV BUTTONS */
.nav-btn{padding:9px 18px;background:transparent;border:1px solid var(--border);border-radius:10px;color:var(--muted);font-size:13px;cursor:pointer;text-decoration:none;transition:all .2s;display:inline-flex;align-items:center;gap:6px}
.nav-btn:hover{border-color:var(--accent);color:var(--text)}

@media(max-width:900px){body{grid-template-columns:1fr}.sidebar{display:none}.main-inner{padding:20px 16px 60px}}
@media(max-width:500px){.info-grid{grid-template-columns:1fr}.tips-grid{grid-template-columns:1fr}}
</style>
</head>
<body>

{{-- SIDEBAR (identique) --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('assets/logo.png') }}" alt="Fidow">
        <div>
            <div class="sidebar-logo-text">Fidow</div>
        </div>
        <div style="margin-left:auto"><div class="sidebar-badge">Admin</div></div>
    </div>
    <div class="nav-section">Dashboard</div>
    <a href="{{ route('admin.data') }}" class="nav-item active">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        Générations
    </a>
    <a href="{{ route('stats') }}" class="nav-item" target="_blank">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><line x1="12" y1="20" x2="12" y2="4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><line x1="6" y1="20" x2="6" y2="14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        Stats publiques ↗
    </a>
    <div class="nav-section">Site</div>
    <a href="{{ route('home') }}" class="nav-item" target="_blank">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20" stroke="currentColor" stroke-width="1.5"/></svg>
        Voir le site ↗
    </a>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Déconnexion
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<main class="main">
<div class="main-inner">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.data') }}">Générations</a>
        <span class="breadcrumb-sep">/</span>
        <span style="color:var(--text2)">#{{ $generation->id }}</span>
    </div>

    <div class="page-title">Détail de la génération</div>
    <div class="page-meta">
        <span>
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ $generation->created_at->format('d/m/Y à H:i') }}
        </span>
        <span>
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
            {{ $generation->ip_address }}
        </span>
        @if($generation->phrase_retenue)
            <span class="badge badge-green">
                <svg width="8" height="8" fill="none" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                Phrase retenue
            </span>
        @else
            <span class="badge badge-muted">Non retenue</span>
        @endif
    </div>

    {{-- PROFIL --}}
    <div class="card">
        <div class="card-title">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>
            Profil utilisateur
        </div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Métier</div>
                <div class="info-value">{{ $generation->metier ?: '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Niveau</div>
                <div class="info-value">{{ $generation->niveau ?: '—' }}</div>
            </div>
            @if($generation->techno)
            <div class="info-item info-full">
                <div class="info-label">Technologies</div>
                <div class="info-value">{{ $generation->techno }}</div>
            </div>
            @endif
            <div class="info-item">
                <div class="info-label">Cible</div>
                <div class="info-value">{{ $generation->cible ?: '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Ton choisi</div>
                <div class="info-value">{{ $generation->ton ?: '—' }}</div>
            </div>
            <div class="info-item info-full">
                <div class="info-label">Résultat apporté</div>
                <div class="info-value">{{ $generation->resultat ?: '—' }}</div>
            </div>
            @if($generation->approche)
            <div class="info-item">
                <div class="info-label">Approche</div>
                <div class="info-value">{{ $generation->approche }}</div>
            </div>
            @endif
            @if($generation->extra)
            <div class="info-item">
                <div class="info-label">Infos complémentaires</div>
                <div class="info-value">{{ $generation->extra }}</div>
            </div>
            @endif
            <div class="info-item">
                <div class="info-label">Usages prévus</div>
                <div class="info-value">{{ $generation->usages ?: '—' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Longueur demandée</div>
                <div class="info-value">{{ ['Courte', 'Équilibrée', 'Détaillée'][$generation->longueur - 1] ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- PHRASES --}}
    <div class="card">
        <div class="card-title">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>
            Phrases générées
        </div>

        <div class="phrase-label">Phrase principale</div>
        <div class="phrase-block phrase-main-block">{{ $generation->phrase_1 ?: '—' }}</div>

        @if($generation->phrase_2)
        <div class="phrase-label" style="margin-top:12px">Variante 2</div>
        <div class="phrase-block phrase-alt-block">{{ $generation->phrase_2 }}</div>
        @endif

        @if($generation->phrase_3)
        <div class="phrase-label" style="margin-top:12px">Variante 3</div>
        <div class="phrase-block phrase-alt-block">{{ $generation->phrase_3 }}</div>
        @endif

        @if($generation->phrase_retenue)
        <div style="margin-top:18px;padding-top:18px;border-top:1px solid rgba(255,255,255,.04)">
            <div class="phrase-label" style="color:var(--green)">✓ Phrase retenue par l'utilisateur</div>
            <div class="phrase-block phrase-retained">{{ $generation->phrase_retenue }}</div>
        </div>
        @endif
    </div>

    {{-- TIPS --}}
    @if($generation->tip_linkedin || $generation->tip_portfolio)
    <div class="card">
        <div class="card-title">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round"/></svg>
            Conseils générés
        </div>
        <div class="tips-grid">
            @if($generation->tip_linkedin)
            <div class="tip-item">
                <div class="tip-label">LinkedIn</div>
                <div class="tip-value">{{ $generation->tip_linkedin }}</div>
            </div>
            @endif
            @if($generation->tip_portfolio)
            <div class="tip-item">
                <div class="tip-label">Portfolio</div>
                <div class="tip-value">{{ $generation->tip_portfolio }}</div>
            </div>
            @endif
            @if($generation->tip_freelance)
            <div class="tip-item">
                <div class="tip-label">Malt / Upwork</div>
                <div class="tip-value">{{ $generation->tip_freelance }}</div>
            </div>
            @endif
            @if($generation->tip_candidature)
            <div class="tip-item">
                <div class="tip-label">Candidature</div>
                <div class="tip-value">{{ $generation->tip_candidature }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- META TECHNIQUE --}}
    <div class="card">
        <div class="card-title">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="currentColor" stroke-width="1.5"/></svg>
            Données techniques
        </div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">ID</div>
                <div class="info-value mono">{{ $generation->id }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Créé le</div>
                <div class="info-value">{{ $generation->created_at->format('d/m/Y H:i:s') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Adresse IP</div>
                <div class="info-value mono">{{ $generation->ip_address }}</div>
            </div>
            @if($generation->user_agent)
            <div class="info-item info-full">
                <div class="info-label">User Agent</div>
                <div class="info-value mono" style="font-size:11px;word-break:break-all">{{ $generation->user_agent }}</div>
            </div>
            @endif
        </div>
    </div>

    <div style="display:flex;gap:10px;margin-top:8px">
        <a href="{{ route('admin.data') }}" class="nav-btn">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Retour à la liste
        </a>
    </div>

</div>
</main>

</body>
</html>
