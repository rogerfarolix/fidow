<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Phrase de Positionnement — Fidow</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@400;500;700;800;900&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
:root{--bg:#080606;--s1:#0f0a0a;--s2:#170e0e;--s3:#1f1414;--accent:#872323;--accent2:#a82b2b;--aglow:rgba(135,35,35,.22);--gold:#e8a030;--green:#2ef0a0;--text:#f4eded;--text2:#c8b8b8;--muted:#6b5757;--border:rgba(135,35,35,.2);--border2:rgba(255,255,255,.05);--r:14px;--r2:20px}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;overflow-x:hidden}
.ambient{position:fixed;inset:0;pointer-events:none;z-index:0;background:radial-gradient(ellipse 70% 50% at 15% 0%,rgba(135,35,35,.14) 0%,transparent 65%),radial-gradient(ellipse 45% 35% at 85% 100%,rgba(135,35,35,.10) 0%,transparent 60%)}
.noise{position:fixed;inset:0;pointer-events:none;z-index:0;opacity:.028;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-size:256px}
.wrap{position:relative;z-index:1;max-width:820px;margin:0 auto;padding:64px 24px 100px}

/* ── NAV ── */
.fidow-nav{position:sticky;top:0;z-index:100;backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);background:rgba(8,6,6,.7);border-bottom:1px solid rgba(135,35,35,.12);padding:0 28px}
.nav-inner{max-width:1180px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;height:64px;gap:24px}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo img{height:30px;width:auto}
.nav-links{display:flex;align-items:center;gap:6px}
.nav-links a{color:var(--muted);text-decoration:none;font-size:13px;font-weight:500;padding:7px 13px;border-radius:8px;transition:all .2s}
.nav-links a:hover{color:var(--text);background:rgba(135,35,35,.1)}
.live-dot{display:inline-block;width:7px;height:7px;border-radius:50%;background:var(--green);box-shadow:0 0 8px var(--green);animation:pulse-dot 2s ease infinite}
@keyframes pulse-dot{0%,100%{opacity:1}50%{opacity:.25}}

/* ── HERO ── */
.hero{text-align:center;margin-bottom:44px}
.hero-pill{display:inline-flex;align-items:center;gap:8px;background:rgba(135,35,35,.1);border:1px solid rgba(135,35,35,.25);border-radius:100px;padding:5px 16px 5px 10px;font-size:11px;font-weight:600;letter-spacing:.09em;text-transform:uppercase;color:#d47070;margin-bottom:26px}
h1{font-family:'Cabinet Grotesk',sans-serif;font-size:clamp(34px,6vw,58px);font-weight:900;line-height:1.04;letter-spacing:-.04em;margin-bottom:16px}
.grad{background:linear-gradient(90deg,#e05555 0%,#872323 40%,#e07050 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;background-size:200%;animation:shimmer 5s linear infinite}
@keyframes shimmer{0%{background-position:0%}100%{background-position:200%}}
.hero-sub{color:var(--muted);font-size:15px;line-height:1.75;max-width:500px;margin:0 auto}

/* ── FORMAT STRIP ── */
.format-strip{background:var(--s1);border:1px solid var(--border);border-radius:14px;padding:18px 22px;margin-bottom:28px;display:flex;align-items:flex-start;gap:14px}
.format-label{font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#d47070;margin-bottom:5px}
.format-text{font-family:'Cabinet Grotesk',sans-serif;font-size:15px;font-weight:700;line-height:1.5;color:var(--text)}
.format-text b{color:var(--gold);font-weight:800}

/* ── STEPS BAR ── */
.steps-bar{display:flex;margin-bottom:24px;border-radius:14px;overflow:hidden;border:1px solid var(--border)}
.step-tab{flex:1;padding:13px 8px;background:var(--s1);text-align:center;font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);cursor:pointer;transition:all .22s;border-right:1px solid var(--border);display:flex;flex-direction:column;align-items:center;gap:4px}
.step-tab:last-child{border-right:none}
.step-tab.active{background:rgba(135,35,35,.12);color:#d47070}
.step-tab.done{background:rgba(46,240,160,.05);color:var(--green)}
.step-num{font-size:17px;font-weight:900;font-family:'Cabinet Grotesk',sans-serif}

/* ── CARD ── */
.card{background:var(--s1);border:1px solid var(--border);border-radius:20px;padding:38px;margin-bottom:20px;box-shadow:0 0 80px rgba(135,35,35,.05)}
.section-title{font-family:'Cabinet Grotesk',sans-serif;font-size:18px;font-weight:800;margin-bottom:5px;display:flex;align-items:center;gap:10px}
.section-icon{width:34px;height:34px;border-radius:10px;background:rgba(135,35,35,.12);border:1px solid rgba(135,35,35,.2);display:grid;place-items:center;flex-shrink:0}
.section-desc{color:var(--muted);font-size:13px;margin-bottom:26px;line-height:1.55;padding-left:44px}

.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.col-full{grid-column:1/-1}
.field{display:flex;flex-direction:column;gap:7px}
label{font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted)}
label .req{color:var(--accent2)}
input,textarea,select{background:var(--s2);border:1px solid rgba(255,255,255,.07);border-radius:11px;padding:12px 14px;color:var(--text);font-family:'DM Sans',sans-serif;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;width:100%}
input::placeholder,textarea::placeholder{color:var(--muted);font-style:italic}
textarea{resize:vertical;min-height:88px}
select{cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b5757' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;padding-right:40px}
select option{background:#170e0e}
input:focus,textarea:focus,select:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(135,35,35,.14)}

/* ── METIER GRID ── */
.metier-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(128px,1fr));gap:8px;margin-bottom:14px}
.mc{padding:10px 10px;background:var(--s2);border:1px solid rgba(255,255,255,.07);border-radius:10px;font-size:12px;font-weight:500;color:var(--muted);cursor:pointer;transition:all .2s;text-align:center;display:flex;flex-direction:column;align-items:center;gap:6px;user-select:none}
.mc:hover{border-color:rgba(135,35,35,.35);color:var(--text)}
.mc.sel{background:rgba(135,35,35,.12);border-color:var(--accent);color:#d47070;box-shadow:0 0 16px rgba(135,35,35,.15)}

/* ── TAGS ── */
.tags-wrap{background:var(--s2);border:1px solid rgba(255,255,255,.07);border-radius:11px;padding:9px 12px;display:flex;flex-wrap:wrap;gap:7px;align-items:center;min-height:48px;cursor:text;transition:border-color .2s,box-shadow .2s}
.tags-wrap:focus-within{border-color:var(--accent);box-shadow:0 0 0 3px rgba(135,35,35,.14)}
.tag{display:inline-flex;align-items:center;gap:5px;background:rgba(135,35,35,.15);border:1px solid rgba(135,35,35,.3);border-radius:6px;padding:3px 9px;font-size:12px;color:#d47070;font-weight:500}
.tag-del{cursor:pointer;opacity:.6;font-size:14px;line-height:1}
.tag-del:hover{opacity:1}
.tag-input{border:none;background:transparent;outline:none;color:var(--text);font-size:13px;font-family:'DM Sans',sans-serif;flex:1;min-width:100px;padding:2px 4px}
.tag-input::placeholder{color:var(--muted);font-style:italic}
.suggestions{display:flex;flex-wrap:wrap;gap:5px;margin-top:9px}
.sug{padding:3px 11px;background:var(--s2);border:1px solid rgba(255,255,255,.08);border-radius:100px;font-size:11px;color:var(--muted);cursor:pointer;transition:all .15s}
.sug:hover{border-color:rgba(135,35,35,.35);color:var(--text)}

/* ── SLIDER ── */
.slider-row{display:flex;align-items:center;gap:12px}
input[type=range]{flex:1;height:4px;background:var(--s3);border-radius:2px;accent-color:var(--accent);padding:0;border:none;outline:none;box-shadow:none}
.longueur-lbl{text-align:center;font-size:11px;color:#d47070;margin-top:4px}

/* ── CHIPS ── */
.chips{display:flex;flex-wrap:wrap;gap:7px}
.chip{padding:8px 15px;background:var(--s2);border:1px solid rgba(255,255,255,.08);border-radius:100px;font-size:13px;font-weight:500;color:var(--muted);cursor:pointer;transition:all .2s;user-select:none}
.chip:hover{border-color:rgba(135,35,35,.35);color:var(--text)}
.chip.sel-red{background:rgba(135,35,35,.14);border-color:var(--accent);color:#d47070}
.chip.sel-gold{background:rgba(232,160,48,.1);border-color:var(--gold);color:var(--gold)}

/* ── NAV BUTTONS ── */
.nav-row{display:flex;gap:12px;justify-content:space-between;align-items:center;margin-top:28px}
.btn-prev{padding:11px 22px;background:transparent;border:1px solid var(--border);border-radius:11px;color:var(--muted);font-family:'DM Sans',sans-serif;font-size:14px;cursor:pointer;transition:all .2s}
.btn-prev:hover{border-color:rgba(135,35,35,.35);color:var(--text)}
.btn-next{padding:12px 26px;background:linear-gradient(135deg,var(--accent) 0%,#6b1a1a 100%);border:none;border-radius:11px;color:#fff;font-family:'Cabinet Grotesk',sans-serif;font-size:14px;font-weight:800;cursor:pointer;transition:all .2s;box-shadow:0 5px 20px rgba(135,35,35,.35);display:flex;align-items:center;gap:8px}
.btn-next:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 9px 28px rgba(135,35,35,.5)}
.btn-next:disabled{opacity:.5;cursor:not-allowed;transform:none}

.btn-gen{width:100%;padding:17px 32px;background:linear-gradient(135deg,var(--accent) 0%,#6b1a1a 50%,#a82b2b 100%);background-size:200%;animation:shimmer 4s linear infinite;border:none;border-radius:13px;color:#fff;font-family:'Cabinet Grotesk',sans-serif;font-size:16px;font-weight:900;letter-spacing:.02em;cursor:pointer;transition:transform .2s,box-shadow .2s;box-shadow:0 8px 32px rgba(135,35,35,.38);display:flex;align-items:center;justify-content:center;gap:10px}
.btn-gen:hover:not(:disabled){transform:translateY(-3px);box-shadow:0 14px 44px rgba(135,35,35,.55)}
.btn-gen:disabled{opacity:.55;cursor:not-allowed;animation:none;transform:none}

/* ── SPINNER ── */
.spinner{width:17px;height:17px;border:2px solid rgba(255,255,255,.25);border-top-color:#fff;border-radius:50%;animation:spin .65s linear infinite;display:inline-block}
@keyframes spin{to{transform:rotate(360deg)}}

/* ── ERROR ── */
.error-box{display:none;margin-top:12px;padding:11px 15px;border-radius:10px;background:rgba(135,35,35,.1);border:1px solid rgba(135,35,35,.3);color:#e05555;font-size:13px;line-height:1.5}

/* ── RESULT ── */
.result-card{background:var(--s1);border:1px solid rgba(46,240,160,.2);border-radius:20px;padding:38px;box-shadow:0 0 70px rgba(46,240,160,.05);margin-bottom:20px}
.result-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(46,240,160,.1);border:1px solid rgba(46,240,160,.22);border-radius:100px;padding:4px 14px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--green);margin-bottom:18px}
.phrase-main{font-family:'Cabinet Grotesk',sans-serif;font-size:clamp(18px,2.8vw,24px);font-weight:800;line-height:1.42;color:var(--text);background:var(--s2);border-radius:13px;padding:22px;border-left:4px solid var(--green);margin-bottom:20px;cursor:pointer;transition:box-shadow .2s}
.phrase-main:hover{box-shadow:0 0 24px rgba(46,240,160,.07)}

.action-row{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px}
.btn-act{padding:8px 16px;border-radius:9px;background:transparent;border:1px solid var(--border);color:var(--muted);font-family:'DM Sans',sans-serif;font-size:12px;font-weight:500;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:6px}
.btn-act:hover{border-color:var(--accent);color:var(--text);background:rgba(135,35,35,.08)}
.btn-act.copied{border-color:var(--green)!important;color:var(--green)!important}

.divider{height:1px;background:rgba(255,255,255,.04);margin:0 0 20px}
.var-title{font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:10px}
.var-item{padding:14px 16px;background:var(--s2);border:1px solid rgba(255,255,255,.05);border-radius:11px;font-size:13px;line-height:1.6;color:var(--muted);cursor:pointer;transition:all .2s;margin-bottom:7px}
.var-item:hover{border-color:rgba(135,35,35,.3);color:var(--text)}
.var-item.active-var{border-color:var(--green);color:var(--text);background:rgba(46,240,160,.04)}

/* ── TIPS ── */
.tips-card{background:var(--s1);border:1px solid var(--border);border-radius:16px;padding:22px 26px;margin-bottom:20px}
.tips-title{font-family:'Cabinet Grotesk',sans-serif;font-size:14px;font-weight:800;margin-bottom:12px;color:var(--gold);display:flex;align-items:center;gap:7px}
.tips-grid{display:grid;grid-template-columns:1fr 1fr;gap:9px}
.tip-card{background:var(--s2);border-radius:10px;padding:13px;font-size:13px;line-height:1.5;color:var(--muted)}
.tip-card strong{display:block;color:var(--text);font-weight:600;margin-bottom:4px;font-size:10px;text-transform:uppercase;letter-spacing:.06em}

/* ── RESET ── */
.reset-bar{text-align:center;padding:14px;background:transparent;border:1px solid var(--border);border-radius:13px;display:flex;align-items:center;justify-content:center;gap:12px}
.btn-reset{background:transparent;border:1px solid rgba(135,35,35,.3);border-radius:8px;padding:6px 14px;color:#d47070;font-size:12px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif}
.btn-reset:hover{background:rgba(135,35,35,.08)}

@keyframes rise{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:none}}
.rise{animation:rise .8s cubic-bezier(.22,1,.36,1) both}

@media(max-width:600px){
    .wrap{padding:40px 16px 80px}
    .card{padding:22px 16px}
    .grid-2{grid-template-columns:1fr}
    .metier-grid{grid-template-columns:repeat(auto-fill,minmax(110px,1fr))}
    .tips-grid{grid-template-columns:1fr}
    .result-card{padding:22px 16px}
    .steps-bar{display:none}
}
</style>
</head>
<body x-data="app()" x-init="init()">
<div class="ambient"></div>
<div class="noise"></div>

{{-- NAV --}}
<nav class="fidow-nav">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('assets/logo.png') }}" alt="Fidow">
        </a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('stats') }}">Stats</a>
        </div>
        <span style="font-size:12px;color:var(--muted);background:var(--s1);border:1px solid var(--border);border-radius:100px;padding:4px 12px">
            <span class="live-dot"></span>&nbsp;IA active
        </span>
    </div>
</nav>

<div class="wrap">

    {{-- HERO --}}
    <div class="hero rise">
        <div class="hero-pill"><span class="live-dot"></span>Outil IA — 100 % Gratuit</div>
        <h1>Ta <span class="grad">phrase de positionnement</span><br>en 3 étapes</h1>
        <p class="hero-sub">L'IA génère une phrase percutante que tu utiliseras partout — LinkedIn, portfolio, candidatures, réseaux.</p>
    </div>

    {{-- FORMAT --}}
    <div class="format-strip rise">
        <div style="margin-top:2px;flex-shrink:0">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" stroke="#d47070" stroke-width="1.5"/><path d="M7 8h10M7 12h7M7 16h5" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <div>
            <div class="format-label">Le format à maîtriser</div>
            <div class="format-text">« Je <b>[verbe + ce que tu fais]</b> pour <b>[qui]</b> afin de <b>[résultat concret]</b>. »</div>
        </div>
    </div>

    {{-- STEPS BAR --}}
    <div class="steps-bar rise">
        <div class="step-tab" :class="{ active: step===1, done: step>1 }" @click="step>1 && goStep(1)">
            <div class="step-num">1</div>Métier
        </div>
        <div class="step-tab" :class="{ active: step===2, done: step>2 }">
            <div class="step-num">2</div>Cible & Résultat
        </div>
        <div class="step-tab" :class="{ active: step===3 }">
            <div class="step-num">3</div>Affiner
        </div>
    </div>

    {{-- MAIN CARD --}}
    <div class="card rise">

        {{-- STEP 1 --}}
        <div x-show="step===1" x-transition>
            <div class="section-title">
                <div class="section-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                Ton métier & tes compétences
            </div>
            <p class="section-desc">Clique sur ton profil principal, puis précise tes technologies ou spécialités.</p>

            <div class="field" style="margin-bottom:18px">
                <label>Ton profil principal <span class="req">*</span></label>
                <div class="metier-grid">
                    <template x-for="m in metiers" :key="m.id">
                        <div class="mc" :class="{ sel: metierSel===m.id }" @click="selectMetier(m.id)">
                            <span x-html="m.svg"></span>
                            <span x-text="m.label"></span>
                        </div>
                    </template>
                </div>
                <input type="text" x-model="metierCustom" placeholder="Ou écris ton métier si non listé…" @input="metierSel=null" />
            </div>

            <div class="field" style="margin-bottom:18px">
                <label>Technologies, outils & frameworks</label>
                <div class="tags-wrap" @click="$refs.tagInput.focus()">
                    <template x-for="t in technoTags" :key="t">
                        <div class="tag">
                            <span x-text="t"></span>
                            <span class="tag-del" @click.stop="removeTag(t)">&times;</span>
                        </div>
                    </template>
                    <input class="tag-input" x-ref="tagInput" placeholder="ex : React, Figma, n8n… (Entrée pour ajouter)"
                        @keydown.enter.prevent="addTag($refs.tagInput.value); $refs.tagInput.value=''"
                        @keydown.comma.prevent="addTag($refs.tagInput.value); $refs.tagInput.value=''"
                        @keydown.backspace="$refs.tagInput.value==='' && technoTags.length && removeTag(technoTags[technoTags.length-1])"/>
                </div>
                <div class="suggestions">
                    <template x-for="s in technoSuggestions" :key="s">
                        <span class="sug" @click="addTag(s)" x-text="s"></span>
                    </template>
                </div>
            </div>

            <div class="field">
                <label>Niveau d'expérience</label>
                <select x-model="niveau">
                    <option value="">— Sélectionner —</option>
                    <option value="junior (0–2 ans)">Junior (0–2 ans)</option>
                    <option value="confirmé (2–5 ans)">Confirmé (2–5 ans)</option>
                    <option value="senior (5+ ans)">Senior (5+ ans)</option>
                    <option value="expert reconnu dans mon domaine">Expert reconnu</option>
                </select>
            </div>

            <div class="nav-row">
                <div></div>
                <button class="btn-next" @click="goStep(2)">Étape suivante →</button>
            </div>
            <div class="error-box" :style="{ display: error ? 'block' : 'none' }" x-text="error"></div>
        </div>

        {{-- STEP 2 --}}
        <div x-show="step===2" x-transition>
            <div class="section-title">
                <div class="section-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="#d47070" stroke-width="1.5"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>
                </div>
                Public cible & résultat
            </div>
            <p class="section-desc">Qui bénéficie de ton travail, et qu'est-ce que ça change concrètement pour eux ?</p>

            <div class="grid-2">
                <div class="field col-full">
                    <label>Type de clients / employeurs visés <span class="req">*</span></label>
                    <select x-model="cibleType">
                        <option value="">— Sélectionner —</option>
                        <optgroup label="Entreprises">
                            <option value="startups early-stage">Startups early-stage</option>
                            <option value="startups B2B SaaS">Startups B2B SaaS</option>
                            <option value="PME africaines">PME africaines</option>
                            <option value="PME et TPE">PME et TPE</option>
                            <option value="grandes entreprises et groupes">Grandes entreprises / Groupes</option>
                            <option value="entreprises e-commerce">Entreprises e-commerce</option>
                            <option value="fintech">Fintech</option>
                            <option value="edtech">Edtech</option>
                            <option value="healthtech">Healthtech</option>
                        </optgroup>
                        <optgroup label="Professionnels">
                            <option value="entrepreneurs et solopreneurs">Entrepreneurs & Solopreneurs</option>
                            <option value="agences digitales et studios web">Agences digitales / Studios web</option>
                            <option value="freelances et indépendants">Freelances & Indépendants</option>
                            <option value="créateurs de contenu">Créateurs de contenu</option>
                        </optgroup>
                        <optgroup label="Secteurs">
                            <option value="organisations du secteur public et ONG">Secteur public & ONG</option>
                            <option value="établissements d'enseignement">Établissements d'enseignement</option>
                            <option value="cliniques et acteurs de la santé">Santé & Cliniques</option>
                            <option value="acteurs de l'immobilier">Immobilier</option>
                            <option value="acteurs de la restauration et hôtellerie">Restauration & Hôtellerie</option>
                        </optgroup>
                    </select>
                </div>
                <div class="field col-full">
                    <label>Précise davantage (optionnel)</label>
                    <input type="text" x-model="cibleCustom" placeholder="ex : basées en Afrique de l'Ouest, avec 10–50 employés…" />
                </div>
                <div class="field col-full">
                    <label>Le résultat concret que tu leur apportes <span class="req">*</span></label>
                    <textarea x-model="resultat" rows="3" placeholder="ex : lancer leur MVP en 8 semaines, multiplier leur taux de conversion…"></textarea>
                </div>
                <div class="field col-full">
                    <label>Ton approche ou ce qui te distingue (optionnel)</label>
                    <input type="text" x-model="approche" placeholder="ex : mobile-first, orienté accessibilité, full remote, avec IA intégrée…" />
                </div>
            </div>

            <div class="nav-row">
                <button class="btn-prev" @click="goStep(1)">← Retour</button>
                <button class="btn-next" @click="goStep(3)">Étape suivante →</button>
            </div>
            <div class="error-box" :style="{ display: error ? 'block' : 'none' }" x-text="error"></div>
        </div>

        {{-- STEP 3 --}}
        <div x-show="step===3" x-transition>
            <div class="section-title">
                <div class="section-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#d47070" stroke-width="1.5" stroke-linejoin="round"/></svg>
                </div>
                Affine ta phrase
            </div>
            <p class="section-desc">Ces options permettent à l'IA de calibrer le ton et l'usage exact de ta phrase.</p>

            <div class="grid-2">
                <div class="field col-full">
                    <label>Où sera-t-elle utilisée ? (choix multiples)</label>
                    <div class="chips">
                        <template x-for="u in usageOptions" :key="u">
                            <div class="chip" :class="{ 'sel-red': usages.includes(u) }" @click="toggleUsage(u)" x-text="u"></div>
                        </template>
                    </div>
                </div>
                <div class="field col-full">
                    <label>Ton de la phrase</label>
                    <div class="chips">
                        <template x-for="t in toneOptions" :key="t">
                            <div class="chip" :class="{ 'sel-gold': ton===t }" @click="ton=t" x-text="t"></div>
                        </template>
                    </div>
                </div>
                <div class="field col-full">
                    <label>Longueur idéale</label>
                    <div class="slider-row">
                        <span style="font-size:11px;color:var(--muted)">Courte</span>
                        <input type="range" x-model="longueur" min="1" max="3" step="1" />
                        <span style="font-size:11px;color:var(--muted)">Détaillée</span>
                    </div>
                    <div class="longueur-lbl" x-text="longueurLabels[longueur-1]"></div>
                </div>
                <div class="field col-full">
                    <label>Informations complémentaires (optionnel)</label>
                    <textarea x-model="extra" rows="2" placeholder="Projets marquants, certifications, zone géographique, valeurs…"></textarea>
                </div>
            </div>

            <div class="nav-row" style="margin-top:24px">
                <button class="btn-prev" @click="goStep(2)">← Retour</button>
                <div></div>
            </div>

            <div style="margin-top:18px">
                <button class="btn-gen" @click="generate(false)" :disabled="loading">
                    <template x-if="loading"><span class="spinner"></span></template>
                    <template x-if="!loading">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </template>
                    <span x-text="loading ? 'L\'IA génère ta phrase…' : 'Générer ma phrase de positionnement'"></span>
                </button>
            </div>
            <div class="error-box" :style="{ display: error ? 'block' : 'none' }" x-text="error"></div>
        </div>

    </div>

    {{-- RESULT --}}
    <div x-show="result.p1" x-transition style="display:none">

        <div class="result-card">
            <div class="result-badge">
                <svg width="10" height="10" fill="none" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" stroke="#2ef0a0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Ta phrase générée
            </div>

            <div class="phrase-main" x-text="activePhrase"></div>

            <div class="action-row">
                <button class="btn-act" :class="{ copied: copied }" @click="copyPhrase()">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" stroke="currentColor" stroke-width="1.5"/></svg>
                    <span x-text="copied ? 'Copié !' : 'Copier'"></span>
                </button>
                <button class="btn-act" @click="generate(true)" :disabled="loading">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M23 4v6h-6M1 20v-6h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Régénérer
                </button>
            </div>

            <div class="divider"></div>
            <div class="var-title">2 autres versions — clique pour sélectionner</div>
            <template x-for="(p, i) in [result.p2, result.p3]" :key="i">
                <div class="var-item" :class="{ 'active-var': activePhrase===p }" @click="activePhrase=p" x-text="p"></div>
            </template>
        </div>

        <div class="tips-card">
            <div class="tips-title">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Comment utiliser ta phrase
            </div>
            <div class="tips-grid">
                <div class="tip-card"><strong>LinkedIn</strong><span x-text="result.tip_linkedin"></span></div>
                <div class="tip-card"><strong>Portfolio</strong><span x-text="result.tip_portfolio"></span></div>
                <div class="tip-card"><strong>Malt / Upwork</strong><span x-text="result.tip_freelance"></span></div>
                <div class="tip-card"><strong>Candidature</strong><span x-text="result.tip_candidature"></span></div>
            </div>
        </div>

        <div class="reset-bar">
            <span style="color:var(--muted);font-size:13px">Tu veux modifier tes informations ?</span>
            <button class="btn-reset" @click="resetAll()">Recommencer</button>
        </div>
    </div>

</div>

<script>
function app() {
    return {
        step: 1, error: '', loading: false, copied: false,
        metierSel: null, metierCustom: '', technoTags: [], technoSuggestions: [], niveau: '',
        cibleType: '', cibleCustom: '', resultat: '', approche: '',
        usages: ['LinkedIn'], ton: 'Professionnel & direct', longueur: 2, extra: '',
        result: {}, activePhrase: '',
        longueurLabels: ['Courte (10–18 mots)', 'Équilibrée (20–30 mots)', 'Détaillée (30–45 mots)'],
        usageOptions: ['LinkedIn', 'Portfolio & CV', 'Facebook / Instagram', 'Malt / Upwork / Fiverr', 'Candidature / Prospection', 'Pitch oral'],
        toneOptions: ['Professionnel & direct', 'Ambitieux & impact', 'Accessible & humain', 'Expert & technique', 'Créatif & distinctif'],
        metiers: [
            { id:'dev-web',    label:'Dev Web',         svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><polyline points="8 6 2 12 8 18" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
            { id:'dev-mobile', label:'Dev Mobile',      svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" stroke="#d47070" stroke-width="1.5"/><line x1="12" y1="18" x2="12.01" y2="18" stroke="#d47070" stroke-width="2" stroke-linecap="round"/></svg>' },
            { id:'fullstack',  label:'Fullstack',       svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
            { id:'backend',    label:'Backend',         svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="4" rx="1" stroke="#d47070" stroke-width="1.5"/><rect x="2" y="10" width="20" height="4" rx="1" stroke="#d47070" stroke-width="1.5"/><rect x="2" y="17" width="20" height="4" rx="1" stroke="#d47070" stroke-width="1.5"/></svg>' },
            { id:'frontend',   label:'Frontend',        svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2z" stroke="#d47070" stroke-width="1.5"/><circle cx="7" cy="7" r="1.5" fill="#d47070"/></svg>' },
            { id:'devops',     label:'DevOps / Cloud',  svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
            { id:'data',       label:'Data / BI',       svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/><line x1="12" y1="20" x2="12" y2="4" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/><line x1="6" y1="20" x2="6" y2="14" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>' },
            { id:'ia-ml',      label:'IA / ML',         svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke="#d47070" stroke-width="1.5"/><path d="M12 2v3M12 19v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M2 12h3M19 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>' },
            { id:'ui-ux',      label:'UI/UX Design',    svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#d47070" stroke-width="1.5"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>' },
            { id:'product',    label:'Product Manager', svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke="#d47070" stroke-width="1.5"/><polyline points="14 2 14 8 20 8" stroke="#d47070" stroke-width="1.5"/></svg>' },
            { id:'cybersec',   label:'Cybersécurité',   svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
            { id:'seo-smo',    label:'SEO / SMO',       svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
            { id:'no-code',    label:'No-code / Auto.', svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3" stroke="#d47070" stroke-width="1.5"/><circle cx="6" cy="12" r="3" stroke="#d47070" stroke-width="1.5"/><circle cx="18" cy="19" r="3" stroke="#d47070" stroke-width="1.5"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke="#d47070" stroke-width="1.5"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke="#d47070" stroke-width="1.5"/></svg>' },
            { id:'infra',      label:'Admin Sys / Réseau',svg:'<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="8" rx="2" stroke="#d47070" stroke-width="1.5"/><rect x="2" y="14" width="20" height="8" rx="2" stroke="#d47070" stroke-width="1.5"/></svg>' },
            { id:'blockchain', label:'Blockchain / Web3',svg:'<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
            { id:'content',    label:'Content / Copy',  svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
            { id:'qa',         label:'QA / Test',       svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
            { id:'cto',        label:'CTO / Tech Lead', svg: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' },
        ],
        technoByMetier: {
            'dev-web':    ['HTML/CSS','JavaScript','PHP','Laravel','WordPress','Webflow'],
            'dev-mobile': ['Flutter','React Native','Swift','Kotlin','Expo'],
            'fullstack':  ['React','Vue.js','Node.js','Laravel','Django','PostgreSQL','Docker'],
            'backend':    ['Node.js','Python','Go','Java','Spring Boot','FastAPI','MongoDB'],
            'frontend':   ['React','Vue.js','Next.js','TypeScript','Tailwind CSS','Figma'],
            'devops':     ['Docker','Kubernetes','AWS','GCP','Azure','Terraform','GitHub Actions'],
            'data':       ['Python','SQL','Power BI','Tableau','dbt','BigQuery','Spark'],
            'ia-ml':      ['Python','TensorFlow','PyTorch','LangChain','OpenAI API','HuggingFace','n8n'],
            'ui-ux':      ['Figma','Adobe XD','Protopie','Maze','Framer'],
            'product':    ['Notion','Jira','Mixpanel','Amplitude','Figma','Miro'],
            'cybersec':   ['Kali Linux','Burp Suite','Metasploit','Wireshark','SIEM','ISO 27001'],
            'seo-smo':    ['SEMrush','Ahrefs','Google Analytics','Google Ads','Meta Ads'],
            'no-code':    ['Make.com','n8n','Zapier','Airtable','Bubble','Webflow'],
            'infra':      ['Linux','Windows Server','Cisco','VMware','Active Directory'],
            'blockchain': ['Solidity','Ethereum','Hardhat','Web3.js','IPFS','Rust'],
            'content':    ['Notion','ChatGPT','Midjourney','WordPress','Canva'],
            'qa':         ['Selenium','Cypress','Postman','JMeter','Playwright','JIRA'],
            'cto':        ['Architecture microservices','Scrum','OKR','AWS','System Design'],
        },
        init() {},
        selectMetier(id) { this.metierSel=id; this.metierCustom=''; this.technoSuggestions=this.technoByMetier[id]||[]; },
        addTag(val) { val=val.trim().replace(/,/g,''); if(val&&!this.technoTags.includes(val))this.technoTags.push(val); },
        removeTag(val) { this.technoTags=this.technoTags.filter(t=>t!==val); },
        toggleUsage(u) { if(this.usages.includes(u))this.usages=this.usages.filter(x=>x!==u); else this.usages.push(u); },
        getMetier() { if(this.metierCustom.trim())return this.metierCustom.trim(); if(this.metierSel){const m=this.metiers.find(x=>x.id===this.metierSel);return m?m.label:null;} return null; },
        getCible() { return [this.cibleType,this.cibleCustom.trim()].filter(Boolean).join(', ')||null; },
        goStep(n) {
            this.error='';
            if(n>1&&!this.getMetier()){this.error='Merci de sélectionner ou écrire ton métier principal.';return;}
            if(n>2&&!this.getCible()){this.error='Merci de sélectionner ton public cible.';return;}
            if(n>2&&!this.resultat.trim()){this.error='Merci de décrire le résultat concret que tu apportes.';return;}
            this.step=n;
        },
        async generate(isRegen) {
            const metier=this.getMetier(), cible=this.getCible(), resultat=this.resultat.trim();
            if(!metier||!cible||!resultat){this.error='Informations manquantes. Vérifie les étapes 1 et 2.';return;}
            this.loading=true; this.error=''; this.copied=false;
            try {
                const resp=await fetch('{{ route("generer") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'},body:JSON.stringify({metier,techno:this.technoTags.join(', '),niveau:this.niveau,cible,resultat,approche:this.approche,extra:this.extra,usages:this.usages.join(', '),ton:this.ton,longueur:parseInt(this.longueur),regen:isRegen})});
                const data=await resp.json();
                if(!resp.ok||data.error){this.error=data.error||'Erreur serveur. Réessaie.';return;}
                this.result=data; this.activePhrase=data.p1;
                this.$nextTick(()=>{document.querySelector('.result-card')?.scrollIntoView({behavior:'smooth',block:'start'});});
            } catch(e){this.error='Connexion impossible. Vérifie ta connexion internet.';}
            finally{this.loading=false;}
        },
        async copyPhrase() {
            await navigator.clipboard.writeText(this.activePhrase);
            this.copied=true; setTimeout(()=>this.copied=false,2500);
            if(this.result.generation_id){fetch(`/generation/${this.result.generation_id}/retenir`,{method:'PATCH',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({phrase:this.activePhrase})}).catch(()=>{});}
        },
        resetAll() { this.result={}; this.activePhrase=''; this.step=1; window.scrollTo({top:0,behavior:'smooth'}); },
    }
}
</script>
</body>
</html>
