<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Bannière Pro IA — Fidow</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@400;700;800;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root{--bg:#080606;--s1:#0f0a0a;--s2:#170e0e;--s3:#1f1414;--accent:#872323;--gold:#e8a030;--green:#2ef0a0;--text:#f4eded;--text2:#c8b8b8;--muted:#6b5757;--border:rgba(135,35,35,.2);--border2:rgba(255,255,255,.05)}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;overflow-x:hidden}
.ambient{position:fixed;inset:0;pointer-events:none;z-index:0;background:radial-gradient(ellipse 70% 50% at 15% 0%,rgba(232,160,48,.07) 0%,transparent 65%),radial-gradient(ellipse 45% 35% at 85% 100%,rgba(135,35,35,.08) 0%,transparent 60%)}
.noise{position:fixed;inset:0;pointer-events:none;z-index:0;opacity:.028;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-size:256px}

/* NAV */
.fidow-nav{position:sticky;top:0;z-index:100;backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);background:rgba(8,6,6,.7);border-bottom:1px solid rgba(135,35,35,.12);padding:0 28px}
.nav-inner{max-width:1180px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;height:64px;gap:24px}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo img{height:30px;width:auto}
.nav-links{display:flex;align-items:center;gap:6px}
.nav-links a{color:var(--muted);text-decoration:none;font-size:13px;font-weight:500;padding:7px 13px;border-radius:8px;transition:all .2s}
.nav-links a:hover{color:var(--text);background:rgba(135,35,35,.1)}
.nav-tools{position:relative}
.nav-tools-btn{color:var(--muted);text-decoration:none;font-size:13px;font-weight:500;padding:7px 13px;border-radius:8px;transition:all .2s;cursor:pointer;background:none;border:none;font-family:inherit;display:flex;align-items:center;gap:5px}
.nav-tools-btn:hover{color:var(--text);background:rgba(135,35,35,.1)}
.nav-tools-btn svg{transition:transform .2s}
.nav-tools-btn.open svg{transform:rotate(180deg)}
.tools-dropdown{position:absolute;top:calc(100% + 8px);right:0;background:var(--s1);border:1px solid var(--border);border-radius:12px;padding:6px;min-width:200px;box-shadow:0 8px 32px rgba(0,0,0,.4);opacity:0;pointer-events:none;transform:translateY(-6px);transition:all .18s}
.tools-dropdown.open{opacity:1;pointer-events:all;transform:none}
.tools-dropdown a{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;color:var(--muted);text-decoration:none;font-size:13px;transition:all .15s}
.tools-dropdown a:hover{color:var(--text);background:rgba(135,35,35,.1)}
.tools-dropdown a .tool-icon{width:28px;height:28px;border-radius:7px;display:grid;place-items:center;flex-shrink:0}
.tools-dropdown a.current{color:var(--text);background:rgba(232,160,48,.08)}

.wrap{position:relative;z-index:1;max-width:980px;margin:0 auto;padding:56px 24px 100px}

/* HERO */
.hero{text-align:center;margin-bottom:48px}
.hero-pill{display:inline-flex;align-items:center;gap:8px;background:rgba(232,160,48,.08);border:1px solid rgba(232,160,48,.2);border-radius:100px;padding:5px 16px 5px 10px;font-size:11px;font-weight:600;letter-spacing:.09em;text-transform:uppercase;color:#e8a030;margin-bottom:22px}
.hero-pill-dot{width:7px;height:7px;border-radius:50%;background:var(--gold);box-shadow:0 0 8px var(--gold)}
h1{font-family:'Cabinet Grotesk',sans-serif;font-size:clamp(30px,5vw,50px);font-weight:900;line-height:1.06;letter-spacing:-.04em;margin-bottom:14px}
.grad-gold{background:linear-gradient(90deg,#fbbf24 0%,#e8a030 40%,#f59e0b 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.hero-sub{color:var(--muted);font-size:15px;line-height:1.7;max-width:560px;margin:0 auto}

/* DIMENSIONS BLOCK */
.dims-block{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:36px}
.dim-card{background:var(--s1);border:1px solid var(--border);border-radius:14px;padding:18px 20px}
.dim-platform{font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--gold);margin-bottom:6px}
.dim-size{font-family:'Cabinet Grotesk',sans-serif;font-size:20px;font-weight:900;color:var(--text);margin-bottom:4px}
.dim-tip{font-size:11px;color:var(--muted);line-height:1.5}

/* HOW TO */
.howto{display:flex;align-items:stretch;gap:0;background:var(--s1);border:1px solid var(--border);border-radius:16px;padding:20px 24px;margin-bottom:36px;gap:24px}
.howto-step{display:flex;align-items:flex-start;gap:10px;flex:1}
.howto-num{width:26px;height:26px;border-radius:8px;background:rgba(232,160,48,.1);border:1px solid rgba(232,160,48,.22);display:grid;place-items:center;font-family:'Cabinet Grotesk',sans-serif;font-size:12px;font-weight:900;color:var(--gold);flex-shrink:0}
.howto-text{font-size:12px;color:var(--muted);line-height:1.5}
.howto-text b{color:var(--text);font-weight:600}
.howto-sep{width:1px;background:var(--border2);flex-shrink:0}

/* TEMPLATES GRID */
.templates-title{font-family:'Cabinet Grotesk',sans-serif;font-size:16px;font-weight:800;margin-bottom:16px;color:var(--text);display:flex;align-items:center;gap:9px}
.templates-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:16px;margin-bottom:48px}

/* CARD TEMPLATE */
.tpl-card{background:var(--s1);border:1px solid var(--border);border-radius:16px;overflow:hidden;cursor:pointer;transition:all .22s;position:relative}
.tpl-card:hover{border-color:rgba(232,160,48,.35);transform:translateY(-2px);box-shadow:0 8px 32px rgba(0,0,0,.25)}
.tpl-card.selected{border-color:var(--gold);box-shadow:0 0 0 1px var(--gold),0 8px 32px rgba(232,160,48,.15)}
.tpl-thumb{width:100%;height:140px;object-fit:cover;display:block;background:var(--s2)}
.tpl-thumb-placeholder{width:100%;height:140px;background:linear-gradient(135deg,var(--s2) 0%,var(--s3) 100%);display:grid;place-items:center;border-bottom:1px solid var(--border2);position:relative;overflow:hidden}
.tpl-thumb-placeholder::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,transparent,transparent 10px,rgba(232,160,48,.03) 10px,rgba(232,160,48,.03) 20px)}
.tpl-body{padding:18px}
.tpl-badge{display:inline-block;font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;border-radius:100px;padding:3px 10px;border:1px solid;margin-bottom:10px}
.tpl-badge-banniere{background:rgba(232,160,48,.08);border-color:rgba(232,160,48,.22);color:#e8a030}
.tpl-titre{font-family:'Cabinet Grotesk',sans-serif;font-size:15px;font-weight:800;margin-bottom:4px;color:var(--text)}
.tpl-sous{font-size:12px;color:var(--muted);margin-bottom:8px}
.tpl-desc{font-size:12px;color:var(--muted);line-height:1.5;margin-bottom:12px}
.tpl-meta{display:flex;gap:8px;flex-wrap:wrap}
.tpl-tag{font-size:10px;background:var(--s2);border:1px solid var(--border2);border-radius:100px;padding:2px 9px;color:var(--muted)}
.tpl-check{position:absolute;top:10px;right:10px;width:26px;height:26px;border-radius:50%;background:var(--gold);display:grid;place-items:center;opacity:0;transform:scale(0.6);transition:all .18s}
.tpl-card.selected .tpl-check{opacity:1;transform:scale(1)}

/* FORM PANEL */
.form-panel{background:var(--s1);border:1px solid rgba(232,160,48,.2);border-radius:20px;padding:36px;margin-bottom:20px;box-shadow:0 0 60px rgba(232,160,48,.04);display:none}
.form-panel.visible{display:block}
.form-panel-title{font-family:'Cabinet Grotesk',sans-serif;font-size:18px;font-weight:800;margin-bottom:6px;display:flex;align-items:center;gap:10px}
.form-panel-sub{color:var(--muted);font-size:13px;margin-bottom:26px;line-height:1.5}

/* CHAMP PHRASE DE POSITIONNEMENT (spécial) */
.phrase-field{background:rgba(232,160,48,.04);border:1px solid rgba(232,160,48,.15);border-radius:13px;padding:18px;margin-bottom:20px}
.phrase-field-label{font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--gold);margin-bottom:8px}
.phrase-field textarea{background:var(--s2);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:12px 14px;color:var(--text);font-family:'DM Sans',sans-serif;font-size:14px;outline:none;transition:border-color .2s;width:100%;resize:vertical;min-height:72px}
.phrase-field textarea:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(232,160,48,.1)}
.phrase-field-hint{font-size:11px;color:var(--muted);margin-top:6px}

.fields-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:22px}
.field{display:flex;flex-direction:column;gap:7px}
.field label{font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted)}
.field input{background:var(--s2);border:1px solid rgba(255,255,255,.07);border-radius:11px;padding:12px 14px;color:var(--text);font-family:'DM Sans',sans-serif;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;width:100%}
.field input::placeholder{color:var(--muted);font-style:italic}
.field input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(232,160,48,.1)}
.field-hint{font-size:11px;color:var(--muted);margin-top:4px;line-height:1.4}
.field-full{grid-column:1/-1}

.btn-generate{width:100%;padding:16px 32px;background:linear-gradient(135deg,#92400e 0%,#e8a030 50%,#f59e0b 100%);background-size:200%;animation:shimmer 4s linear infinite;border:none;border-radius:13px;color:#fff;font-family:'Cabinet Grotesk',sans-serif;font-size:16px;font-weight:900;cursor:pointer;transition:transform .2s,box-shadow .2s;box-shadow:0 8px 32px rgba(232,160,48,.3);display:flex;align-items:center;justify-content:center;gap:10px}
.btn-generate:hover:not(:disabled){transform:translateY(-3px);box-shadow:0 14px 44px rgba(232,160,48,.45)}
.btn-generate:disabled{opacity:.5;cursor:not-allowed;animation:none;transform:none}
@keyframes shimmer{0%{background-position:0%}100%{background-position:200%}}

/* RESULT */
.result-panel{background:var(--s1);border:1px solid rgba(46,240,160,.2);border-radius:20px;padding:36px;margin-top:20px;display:none}
.result-panel.visible{display:block}
.result-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(46,240,160,.1);border:1px solid rgba(46,240,160,.22);border-radius:100px;padding:4px 14px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--green);margin-bottom:18px}
.result-label{font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);margin-bottom:10px}
.prompt-box{background:var(--s2);border:1px solid rgba(255,255,255,.06);border-radius:13px;padding:20px;font-size:13px;line-height:1.8;color:var(--text2);white-space:pre-wrap;word-break:break-word;margin-bottom:16px}
.result-actions{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px}
.btn-copy{padding:10px 20px;border-radius:10px;background:rgba(46,240,160,.1);border:1px solid rgba(46,240,160,.25);color:var(--green);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:7px}
.btn-copy:hover{background:rgba(46,240,160,.18)}
.btn-copy.copied{background:rgba(46,240,160,.2);border-color:var(--green)}
.btn-reset-form{padding:10px 18px;border-radius:10px;background:transparent;border:1px solid var(--border);color:var(--muted);font-family:'DM Sans',sans-serif;font-size:13px;cursor:pointer;transition:all .2s}
.btn-reset-form:hover{color:var(--text);border-color:rgba(135,35,35,.35)}

/* TIPS BLOCK */
.tips-block{background:var(--s2);border:1px solid var(--border2);border-radius:12px;padding:20px;margin-top:20px}
.tips-block-title{font-family:'Cabinet Grotesk',sans-serif;font-size:13px;font-weight:800;color:var(--gold);margin-bottom:14px;display:flex;align-items:center;gap:7px}
.tips-list{display:flex;flex-direction:column;gap:9px}
.tip-item{display:flex;align-items:flex-start;gap:8px;font-size:12px;color:var(--muted);line-height:1.5}
.tip-item b{color:var(--text);font-weight:600}
.tip-dot{width:5px;height:5px;border-radius:50%;background:var(--gold);margin-top:5px;flex-shrink:0}

/* GEMINI TIP */
.gemini-tip{background:var(--s2);border:1px solid var(--border2);border-radius:12px;padding:18px;display:flex;align-items:flex-start;gap:12px;margin-top:16px}
.gemini-tip-icon{width:36px;height:36px;border-radius:10px;background:rgba(232,160,48,.1);border:1px solid rgba(232,160,48,.2);display:grid;place-items:center;flex-shrink:0}
.gemini-tip-text{font-size:13px;color:var(--muted);line-height:1.6}
.gemini-tip-text b{color:var(--text);font-weight:600}
.gemini-tip-text a{color:var(--gold);text-decoration:none}
.gemini-tip-text a:hover{text-decoration:underline}

.spinner{width:16px;height:16px;border:2px solid rgba(255,255,255,.25);border-top-color:#fff;border-radius:50%;animation:spin .65s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

@keyframes rise{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}
.rise{animation:rise .7s cubic-bezier(.22,1,.36,1) both}
.rise-2{animation:rise .7s .12s cubic-bezier(.22,1,.36,1) both}

@media(max-width:640px){
    .wrap{padding:36px 16px 80px}
    .dims-block{grid-template-columns:1fr}
    .fields-grid{grid-template-columns:1fr}
    .howto{flex-direction:column;gap:14px}
    .howto-sep{width:100%;height:1px}
    .templates-grid{grid-template-columns:1fr}
}
</style>
</head>
<body>
<div class="ambient"></div>
<div class="noise"></div>

<nav class="fidow-nav">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('assets/logo.png') }}" alt="Fidow">
        </a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('stats') }}">Stats</a>
            <div class="nav-tools">
                <button class="nav-tools-btn" id="toolsBtn" onclick="toggleDropdown()">
                    Outils
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="tools-dropdown" id="toolsDropdown">
                    <a href="{{ route('positionnement') }}">
                        <div class="tool-icon" style="background:rgba(135,35,35,.1)">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                        Positionnement IA
                    </a>
                    <a href="{{ route('profil') }}">
                        <div class="tool-icon" style="background:rgba(59,130,246,.1)">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="#7bb3ff" stroke-width="1.5"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7" stroke="#7bb3ff" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                        Photo de Profil IA
                    </a>
                    <a href="{{ route('banniere') }}" class="current">
                        <div class="tool-icon" style="background:rgba(232,160,48,.1)">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="10" rx="2" stroke="#e8a030" stroke-width="1.5"/><path d="M7 11h10M7 14h6" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                        Bannière Pro IA
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="wrap">

    {{-- HERO --}}
    <div class="hero rise">
        <div class="hero-pill"><span class="hero-pill-dot"></span>Prompts Bannière — 100% Gratuit</div>
        <h1>Ta <span class="grad-gold">bannière professionnelle</span><br>générée par l'IA</h1>
        <p class="hero-sub">Choisis un style de couverture LinkedIn ou Facebook, renseigne ta phrase de positionnement et tes couleurs, copie le prompt dans Gemini et génère ton visuel en 30 secondes.</p>
    </div>

    {{-- DIMENSIONS --}}
    <div class="dims-block rise">
        <div class="dim-card">
            <div class="dim-platform">LinkedIn Cover</div>
            <div class="dim-size">1584 × 396 px</div>
            <div class="dim-tip">Safe zone centrale : 1350×220 px. ⚠️ Photo de profil recouvre le bas gauche (~300px).</div>
        </div>
        <div class="dim-card">
            <div class="dim-platform">Facebook Cover</div>
            <div class="dim-size">820 × 312 px</div>
            <div class="dim-tip">Safe zone : 640×260 px centre. ⚠️ Photo de profil à gauche + découpe mobile. Génère en 1792×512 pour plus de marge.</div>
        </div>
    </div>

    {{-- HOW TO --}}
    <div class="howto rise">
        <div class="howto-step">
            <div class="howto-num">1</div>
            <div class="howto-text"><b>Choisis un style</b><br>Sélectionne le template de bannière qui correspond à ton identité.</div>
        </div>
        <div class="howto-sep"></div>
        <div class="howto-step">
            <div class="howto-num">2</div>
            <div class="howto-text"><b>Entre tes infos</b><br>Phrase de positionnement, couleurs de ta marque — quelques champs.</div>
        </div>
        <div class="howto-sep"></div>
        <div class="howto-step">
            <div class="howto-num">3</div>
            <div class="howto-text"><b>Génère dans Gemini</b><br>Colle le prompt → génère le fond → ajoute ton texte dans Canva.</div>
        </div>
        <div class="howto-sep"></div>
        <div class="howto-step">
            <div class="howto-num">4</div>
            <div class="howto-text"><b>Finalise dans Canva</b><br>Ajoute ton texte (Poppins Bold), ta photo, et exporte dans les bonnes dimensions.</div>
        </div>
    </div>

    {{-- TEMPLATES --}}
    <div class="rise-2">
        <div class="templates-title">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="10" rx="2" stroke="#e8a030" stroke-width="1.5"/><path d="M7 11h10M7 14h6" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round"/></svg>
            Choisis ton style de bannière ({{ $templates->count() }} disponibles)
        </div>

        <div class="templates-grid" id="templatesGrid">
            @foreach($templates as $tpl)
            <div class="tpl-card" data-id="{{ $tpl->id }}" data-vars="{{ json_encode($tpl->variables ?? []) }}" onclick="selectTemplate(this)">
                @if($tpl->image_path)
                    <img class="tpl-thumb" src="{{ $tpl->image_url }}" alt="{{ $tpl->titre }}">
                @else
                    <div class="tpl-thumb-placeholder">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24" style="opacity:.2"><rect x="2" y="7" width="20" height="10" rx="2" stroke="currentColor" stroke-width="1.2"/><path d="M7 11h10M7 14h6" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    </div>
                @endif
                <div class="tpl-check">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" stroke="#0a0a0a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="tpl-body">
                    <div class="tpl-badge tpl-badge-banniere">Bannière</div>
                    <div class="tpl-titre">{{ $tpl->titre }}</div>
                    <div class="tpl-sous">{{ $tpl->sous_titre }}</div>
                    <div class="tpl-desc">{{ $tpl->description }}</div>
                    <div class="tpl-meta">
                        @if($tpl->plateforme)
                            <span class="tpl-tag">{{ $tpl->plateforme }}</span>
                        @endif
                        @if($tpl->dimensions)
                            <span class="tpl-tag">{{ Str::before($tpl->dimensions, '|') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- FORM PANEL --}}
        <div class="form-panel" id="formPanel">
            <div class="form-panel-title">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span id="formTitle">Personnalise ta bannière</span>
            </div>
            <p class="form-panel-sub" id="formSub">Remplis les champs ci-dessous. Le prompt sera compilé avec tes infos exactes.</p>

            {{-- PHRASE DE POSITIONNEMENT --}}
            <div class="phrase-field">
                <div class="phrase-field-label">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:5px"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    Ta phrase de positionnement (optionnel mais recommandé)
                </div>
                <textarea id="phraseField" placeholder="Ex: Je construis des marques mémorables pour les entrepreneurs africains qui veulent exister en ligne."></textarea>
                <div class="phrase-field-hint">Si tu as déjà généré ta phrase dans l'outil Positionnement IA, colle-la ici — elle guidera le style visuel.</div>
            </div>

            <div class="fields-grid" id="fieldsContainer">
                {{-- Généré dynamiquement --}}
            </div>

            <button class="btn-generate" id="btnGenerate" onclick="compilePrompt()" disabled>
                <span id="btnText">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:6px"><rect x="2" y="7" width="20" height="10" rx="2" stroke="currentColor" stroke-width="1.8"/></svg>
                    Générer mon prompt bannière
                </span>
                <span id="btnSpinner" style="display:none"><div class="spinner"></div>&nbsp;Génération…</span>
            </button>
        </div>

        {{-- RÉSULTAT --}}
        <div class="result-panel" id="resultPanel">
            <div class="result-badge">
                <svg width="9" height="9" fill="none" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                Prompt prêt à l'emploi
            </div>
            <div class="result-label">Ton prompt optimisé pour Gemini Image</div>
            <div class="prompt-box" id="promptBox"></div>
            <div class="result-actions">
                <button class="btn-copy" id="btnCopy" onclick="copyPrompt()">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Copier le prompt
                </button>
                <button class="btn-reset-form" onclick="resetAll()">← Changer de style</button>
            </div>

            <div class="tips-block">
                <div class="tips-block-title">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Astuces pro pour un résultat parfait
                </div>
                <div class="tips-list">
                    <div class="tip-item"><span class="tip-dot"></span><span><b>Génère sans texte</b> — le prompt génère un fond visuel. Ajoute ensuite ton texte dans <b>Canva ou Figma</b> en Poppins Bold.</span></div>
                    <div class="tip-item"><span class="tip-dot"></span><span><b>Photo de profil circulaire</b> — dans Canva, ajoute un cercle avec bordure bleue vif (#3B82F6) de 6-10px sur le bas gauche.</span></div>
                    <div class="tip-item"><span class="tip-dot"></span><span><b>Génère en 1792×512</b> — puis recadre dans Canva aux dimensions exactes (LinkedIn 1584×396 ou Facebook 820×312).</span></div>
                    <div class="tip-item"><span class="tip-dot"></span><span><b>Grain de texture</b> — ajoute un overlay noise à 10-15% d'opacité dans Canva pour une finition premium.</span></div>
                </div>
            </div>

            <div class="gemini-tip">
                <div class="gemini-tip-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="gemini-tip-text">
                    <b>Workflow recommandé :</b> <a href="https://gemini.google.com" target="_blank">Gemini</a> (génération du fond visuel) → <a href="https://canva.com" target="_blank">Canva</a> (ajout texte + photo + export) → Publication. Pour Midjourney, ajoute <code style="background:var(--s1);padding:1px 5px;border-radius:4px;font-size:11px">--ar 4:1 --v 6 --style raw</code> à la fin du prompt.
                </div>
            </div>
        </div>
    </div>

</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

const VAR_LABELS = {
    couleur_bloc1:       { label: 'Couleur Bloc 1 (haut/gauche)', placeholder: 'Ex: #5B2EFF violet profond, ou "indigo sombre"', hint: 'Couleur principale du premier bloc' },
    couleur_bloc2:       { label: 'Couleur Bloc 2 (bas/droite)', placeholder: 'Ex: #F97316 orange vibrant, ou "orange chaud"', hint: 'Couleur du second bloc' },
    couleur_accent:      { label: 'Couleur d\'accent / formes', placeholder: 'Ex: #FFD600 jaune vif, ou "or brillant"', hint: 'Pour les formes géométriques et détails' },
    couleur_cadre_photo: { label: 'Couleur du cadre photo (cercle)', placeholder: 'Ex: #3B82F6 bleu vif (recommandé)', hint: 'Bordure du cercle photo de profil' },
    couleur1:            { label: 'Couleur principale (gauche)', placeholder: 'Ex: #7C3AED violet, ou "violet électrique"', hint: 'Première couleur du dégradé' },
    couleur2:            { label: 'Couleur centrale', placeholder: 'Ex: #3B82F6 bleu, ou "bleu saphir"', hint: 'Couleur de transition centrale' },
    couleur3:            { label: 'Couleur finale (droite)', placeholder: 'Ex: #06B6D4 cyan, ou "turquoise vif"', hint: 'Dernière couleur du dégradé fluide' },
    couleur_fond:        { label: 'Couleur de fond', placeholder: 'Ex: #0f0a0a noir profond, ou "bordeaux très sombre"', hint: 'Couleur principale du fond' },
    couleur_secondaire:  { label: 'Couleur secondaire', placeholder: 'Ex: #e8a030 or, ou "or antique"', hint: 'Accent et détails' },
    couleur_principale:  { label: 'Couleur principale des motifs', placeholder: 'Ex: #872323 rouge, ou "terracotta"', hint: 'Couleur des patterns géométriques' },
    style_metier:        { label: 'Ton métier (pour le style)', placeholder: 'Ex: Consultant marketing, Développeur, Coach business', hint: 'Oriente l\'ambiance visuelle du prompt' },
};

let selectedId = null;
let selectedVars = [];
let compiledPrompt = '';

function toggleDropdown() {
    const btn = document.getElementById('toolsBtn');
    const dd = document.getElementById('toolsDropdown');
    btn.classList.toggle('open');
    dd.classList.toggle('open');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.nav-tools')) {
        document.getElementById('toolsBtn').classList.remove('open');
        document.getElementById('toolsDropdown').classList.remove('open');
    }
});

function selectTemplate(card) {
    document.querySelectorAll('.tpl-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    selectedId   = card.dataset.id;
    selectedVars = JSON.parse(card.dataset.vars || '[]');
    document.getElementById('formTitle').textContent = card.querySelector('.tpl-titre').textContent;
    buildFields(selectedVars);
    document.getElementById('formPanel').classList.add('visible');
    document.getElementById('resultPanel').classList.remove('visible');
    document.getElementById('btnGenerate').disabled = false;
    setTimeout(() => {
        document.getElementById('formPanel').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
}

function buildFields(vars) {
    const container = document.getElementById('fieldsContainer');
    container.innerHTML = '';
    if (!vars || vars.length === 0) return;
    vars.forEach(varKey => {
        const meta = VAR_LABELS[varKey] || { label: varKey.replace(/_/g,' '), placeholder: '', hint: '' };
        const div = document.createElement('div');
        div.className = 'field';
        div.innerHTML = `
            <label>${meta.label}</label>
            <input type="text" name="var_${varKey}" placeholder="${meta.placeholder}" oninput="onFieldInput()">
            ${meta.hint ? `<span class="field-hint">${meta.hint}</span>` : ''}
        `;
        container.appendChild(div);
    });
}

function onFieldInput() {
    const inputs = document.querySelectorAll('#fieldsContainer input');
    const anyFilled = Array.from(inputs).some(i => i.value.trim() !== '');
    document.getElementById('btnGenerate').disabled = !anyFilled && selectedVars.length > 0;
}

async function compilePrompt() {
    if (!selectedId) return;
    document.getElementById('btnText').style.display = 'none';
    document.getElementById('btnSpinner').style.display = 'flex';
    document.getElementById('btnGenerate').disabled = true;

    const inputs = document.querySelectorAll('#fieldsContainer input');
    const variables = {};
    inputs.forEach(input => {
        const key = input.name.replace('var_', '');
        variables[key] = input.value.trim();
    });

    // Injecte la phrase de positionnement si renseignée
    const phrase = document.getElementById('phraseField').value.trim();
    if (phrase) variables['phrase'] = phrase;

    try {
        const res = await fetch(`/banniere/${selectedId}/compiler`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ variables }),
        });
        const data = await res.json();
        compiledPrompt = data.prompt;
        document.getElementById('promptBox').textContent = data.prompt;
        document.getElementById('resultPanel').classList.add('visible');
        document.getElementById('btnCopy').classList.remove('copied');
        document.getElementById('btnCopy').innerHTML = `<svg width="14" height="14" fill="none" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg> Copier le prompt`;
        setTimeout(() => {
            document.getElementById('resultPanel').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    } catch(e) {
        alert('Erreur réseau, réessaie.');
    } finally {
        document.getElementById('btnText').style.display = '';
        document.getElementById('btnSpinner').style.display = 'none';
        document.getElementById('btnGenerate').disabled = false;
    }
}

function copyPrompt() {
    if (!compiledPrompt) return;
    navigator.clipboard.writeText(compiledPrompt).then(() => {
        const btn = document.getElementById('btnCopy');
        btn.classList.add('copied');
        btn.innerHTML = `<svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg> Copié !`;
        setTimeout(() => {
            btn.classList.remove('copied');
            btn.innerHTML = `<svg width="14" height="14" fill="none" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg> Copier le prompt`;
        }, 2500);
    });
}

function resetAll() {
    document.querySelectorAll('.tpl-card').forEach(c => c.classList.remove('selected'));
    document.getElementById('formPanel').classList.remove('visible');
    document.getElementById('resultPanel').classList.remove('visible');
    selectedId = null;
    compiledPrompt = '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
</body>
</html>
