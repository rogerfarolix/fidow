@extends('layouts.app')
@section('title', 'RemoteDigest — 20 offres remote par jour, personnalisées pour toi')

@section('content')
<div class="frd-page">

    <div class="frd-bg" aria-hidden="true">
        <canvas id="rdCanvas"></canvas>
        <div class="frd-ring frd-ring--1"></div>
        <div class="frd-ring frd-ring--2"></div>
        <div class="frd-blob frd-blob--1"></div>
        <div class="frd-blob frd-blob--2"></div>
    </div>

    <div class="frd-container">

        {{-- HERO --}}
        <header class="frd-hero" data-reveal>
            <div class="frd-badge">
                <span class="frd-badge__dot"></span>
                Outil gratuit · Aucun compte requis
            </div>
            <h1 class="frd-hero__title">
                <span>20 offres remote</span><br>
                dans ta boîte mail, chaque soir
            </h1>
            <p class="frd-hero__sub">
                Scraping quotidien de centaines de sources mondiales. Matching IA sur ton profil.
                Jamais les mêmes offres deux fois. Désabonnement en 1 clic.
            </p>
            @if($stats['subscribers'] > 0)
            <div class="frd-hero__kpi">
                <div class="frd-hero__kpi-num">{{ number_format($stats['subscribers']) }}</div>
                <div class="frd-hero__kpi-lbl">abonnés reçoivent leur digest ce soir</div>
            </div>
            @endif
        </header>

        {{-- HOW IT WORKS --}}
        <section class="frd-how" data-reveal>
            <div class="frd-how__step">
                <div class="frd-how__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5"/><path d="M17.5 2.5a2.12 2.12 0 0 1 3 3L12 14l-4 1 1-4Z"/></svg>
                </div>
                <div class="frd-how__n">1</div>
                <h3>Tu remplis ton profil</h3>
                <p>Email, domaine, métier, préférences. 2 minutes chrono.</p>
            </div>
            <div class="frd-how__arrow">→</div>
            <div class="frd-how__step">
                <div class="frd-how__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <div class="frd-how__n">2</div>
                <h3>On scrape + on matche</h3>
                <p>Chaque jour à 6h, on scrape 500+ sources. À 18h30, l'IA sélectionne tes 20 meilleures.</p>
            </div>
            <div class="frd-how__arrow">→</div>
            <div class="frd-how__step">
                <div class="frd-how__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <div class="frd-how__n">3</div>
                <h3>Tu reçois ton digest</h3>
                <p>Un email soigné chaque soir. Offres jamais répétées. Tu cliques, tu postules.</p>
            </div>
        </section>

        {{-- SOURCES --}}
        <section class="frd-sources" data-reveal>
            <div class="frd-sources__label">Sources scrappées chaque jour</div>
            <div class="frd-sources__pills">
                <span class="frd-pill">We Work Remotely</span>
                <span class="frd-pill">Remotive.io</span>
                <span class="frd-pill">Remote.co</span>
                <span class="frd-pill">RemoteOK</span>
                <span class="frd-pill">Trabajo.org</span>
                <span class="frd-pill">Indeed RSS</span>
                <span class="frd-pill">GitHub Jobs</span>
                <span class="frd-pill">+ bien d'autres</span>
            </div>
        </section>

        {{-- FORM --}}
        <section class="frd-form-section" id="commencer" data-reveal>

            @if(session('success'))
            <div class="frd-flash frd-flash--success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="frd-form-header">
                <h2>S'abonner gratuitement</h2>
                <p>Aucun compte, aucun mot de passe. Désabonnement en 1 clic.</p>
            </div>

            <form action="{{ route('digest.subscribe') }}" method="POST" class="frd-form" id="digestForm"
                  x-data="digestForm()">
                @csrf

                {{-- Email --}}
                <div class="frd-field">
                    <label for="email">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        Votre email <span>*</span>
                    </label>
                    <input type="email" id="email" name="email" required placeholder="jean@exemple.com"
                           class="frd-input {{ $errors->has('email') ? 'frd-input--err' : '' }}"
                           value="{{ old('email') }}">
                    @error('email')<p class="frd-error">{{ $message }}</p>@enderror
                </div>

                {{-- Domaine + Métier --}}
                <div class="frd-row-2">
                    <div class="frd-field">
                        <label for="domain">Domaine <span>*</span></label>
                        <select id="domain" name="domain" class="frd-input" x-model="domain" required>
                            <option value="">Choisir...</option>
                            <option value="dev"       {{ old('domain')=='dev' ? 'selected' : '' }}>Développement</option>
                            <option value="design"    {{ old('domain')=='design' ? 'selected' : '' }}>Design / UX-UI</option>
                            <option value="marketing" {{ old('domain')=='marketing' ? 'selected' : '' }}>Marketing Digital</option>
                            <option value="cyber"     {{ old('domain')=='cyber' ? 'selected' : '' }}>Cybersécurité</option>
                            <option value="data"      {{ old('domain')=='data' ? 'selected' : '' }}>Data / IA</option>
                            <option value="product"   {{ old('domain')=='product' ? 'selected' : '' }}>Product Management</option>
                            <option value="other"     {{ old('domain')=='other' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('domain')<p class="frd-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="frd-field">
                        <label for="metier">Métier précis <span>*</span></label>
                        <input type="text" id="metier" name="metier" required
                               placeholder="Ex : Développeur Laravel" class="frd-input"
                               value="{{ old('metier') }}">
                        @error('metier')<p class="frd-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Préférences --}}
                <div class="frd-prefs-toggle">
                    <button type="button" class="frd-toggle-btn" @click="showPrefs = !showPrefs">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                        <span x-text="showPrefs ? 'Masquer les préférences avancées' : 'Préférences avancées (facultatif)'"></span>
                    </button>
                </div>

                <div x-show="showPrefs" x-transition class="frd-prefs-block">
                    <div class="frd-row-2">
                        <div class="frd-field">
                            <label for="type_contrat">Type de contrat</label>
                            <select id="type_contrat" name="preferences[type_contrat]" class="frd-input">
                                <option value="">Tous types</option>
                                <option value="full_time">CDI / Full-time</option>
                                <option value="freelance">Freelance / Mission</option>
                                <option value="part_time">Temps partiel</option>
                                <option value="contract">CDD / Contrat</option>
                            </select>
                        </div>
                        <div class="frd-field">
                            <label for="niveau">Niveau d'expérience</label>
                            <select id="niveau" name="preferences[niveau]" class="frd-input">
                                <option value="">Tous niveaux</option>
                                <option value="junior">Junior (0-2 ans)</option>
                                <option value="mid">Intermédiaire (2-5 ans)</option>
                                <option value="senior">Senior (5-10 ans)</option>
                                <option value="expert">Expert (10+ ans)</option>
                            </select>
                        </div>
                    </div>
                    <div class="frd-row-2">
                        <div class="frd-field">
                            <label for="pays">Préférence pays</label>
                            <input type="text" id="pays" name="preferences[pays]" class="frd-input"
                                   placeholder="Ex : France, Worldwide, Africa">
                        </div>
                        <div class="frd-field">
                            <label for="salaire_min">Salaire minimum (€/an)</label>
                            <input type="number" id="salaire_min" name="preferences[salaire_min]"
                                   class="frd-input" placeholder="Ex : 35000" min="0" max="500000">
                        </div>
                    </div>
                    <div class="frd-field">
                        <label for="send_hour">Heure de réception du digest</label>
                        <select id="send_hour" name="send_hour" class="frd-input">
                            @for($h = 6; $h <= 22; $h++)
                            <option value="{{ $h }}" {{ $h === 19 ? 'selected' : '' }}>{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:00</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <button type="submit" class="frd-submit" id="digestSubmitBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Recevoir mon digest dès ce soir — Gratuit
                </button>

                <p class="frd-form-note">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Désabonnement en 1 clic · Aucun compte requis · 100% gratuit
                </p>
            </form>
        </section>

        {{-- FOOTER NAV --}}
        <div class="frd-footer-nav" data-reveal>
            <a href="{{ route('home') }}" class="frd-nav-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Accueil
            </a>
            <a href="{{ route('positionnement') }}" class="frd-nav-link frd-nav-link--primary">
                Essayer Positionnement Pro
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
:root{--f-red:#872323;--f-ease:cubic-bezier(.16,1,.3,1);}
html.dark{--frd-bg:#0c0c0f;--frd-card:#161619;--frd-soft:#111114;--frd-text1:#f3f4f6;--frd-text2:#d1d5db;--frd-text3:#9ca3af;--frd-border:rgba(255,255,255,.07);}
:root{--frd-bg:#fef7f7;--frd-card:#fff;--frd-soft:#fdf3f3;--frd-text1:#111;--frd-text2:#374151;--frd-text3:#6b7280;--frd-border:rgba(0,0,0,.07);}

[data-reveal]{opacity:0;transform:translateY(26px);transition:opacity .65s var(--f-ease),transform .65s var(--f-ease)}
[data-reveal].is-visible{opacity:1;transform:translateY(0)}

.frd-page{min-height:100vh;background:var(--frd-bg);position:relative;overflow:hidden;padding-bottom:4rem;}
.frd-bg{position:fixed;inset:0;pointer-events:none;z-index:0;}
#rdCanvas{position:absolute;inset:0;width:100%;height:100%;}
.frd-ring{position:absolute;border-radius:50%;border:1px solid rgba(135,35,35,.06);left:50%;top:40%;transform:translate(-50%,-50%);animation:rdRing 10s ease-in-out infinite;}
.frd-ring--1{width:900px;height:900px;}
.frd-ring--2{width:560px;height:560px;animation-delay:3s;border-color:rgba(135,35,35,.04);}
@keyframes rdRing{0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.5}50%{transform:translate(-50%,-50%) scale(1.04);opacity:1}}
.frd-blob{position:absolute;border-radius:50%;filter:blur(100px);}
.frd-blob--1{width:500px;height:280px;background:radial-gradient(ellipse,rgba(135,35,35,.1) 0%,transparent 70%);top:-60px;left:50%;transform:translateX(-50%);}
.frd-blob--2{width:340px;height:340px;background:radial-gradient(circle,rgba(135,35,35,.07) 0%,transparent 70%);bottom:10%;right:-80px;}
.frd-container{position:relative;z-index:2;max-width:820px;margin:0 auto;padding:0 1.5rem;}

/* HERO */
.frd-hero{text-align:center;padding:4.5rem 0 2rem;}
.frd-badge{display:inline-flex;align-items:center;gap:.5rem;padding:.42rem .9rem;border-radius:999px;background:rgba(135,35,35,.07);border:1px solid rgba(135,35,35,.14);color:var(--f-red);font-size:.78rem;font-weight:700;margin-bottom:1.2rem;}
.frd-badge__dot{width:7px;height:7px;border-radius:50%;background:var(--f-red);box-shadow:0 0 0 4px rgba(135,35,35,.12);animation:rdDot 2s ease-in-out infinite;}
@keyframes rdDot{0%,100%{box-shadow:0 0 0 4px rgba(135,35,35,.12)}50%{box-shadow:0 0 0 8px rgba(135,35,35,.04)}}
.frd-hero__title{font-family:'Space Grotesk',sans-serif;font-size:clamp(2.2rem,5vw,3.8rem);font-weight:900;letter-spacing:-.05em;color:var(--frd-text1);margin:0 0 1rem;line-height:1.05;}
.frd-hero__title span{background:linear-gradient(135deg,var(--f-red),#c04040);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.frd-hero__sub{color:var(--frd-text3);font-size:1.05rem;line-height:1.75;max-width:56ch;margin:0 auto 1.5rem;}
.frd-hero__kpi{display:inline-flex;align-items:center;gap:.6rem;background:rgba(135,35,35,.06);border:1px solid rgba(135,35,35,.12);border-radius:14px;padding:.7rem 1.2rem;}
.frd-hero__kpi-num{font-family:'Space Grotesk',sans-serif;font-size:1.6rem;font-weight:900;color:var(--f-red);}
.frd-hero__kpi-lbl{font-size:.84rem;color:var(--frd-text3);}

/* HOW */
.frd-how{display:flex;align-items:flex-start;gap:1rem;background:var(--frd-card);border:1px solid var(--frd-border);border-radius:22px;padding:2rem;margin-bottom:1.5rem;box-shadow:0 8px 32px rgba(0,0,0,.06);}
.frd-how__step{flex:1;text-align:center;}
.frd-how__icon{width:52px;height:52px;border-radius:16px;background:rgba(135,35,35,.08);color:var(--f-red);display:flex;align-items:center;justify-content:center;margin:0 auto .8rem;}
.frd-how__n{font-family:'Space Grotesk',sans-serif;font-size:.75rem;font-weight:800;color:var(--f-red);letter-spacing:.1em;margin-bottom:.4rem;}
.frd-how__step h3{font-size:.95rem;font-weight:800;color:var(--frd-text1);margin:0 0 .4rem;}
.frd-how__step p{font-size:.82rem;color:var(--frd-text3);line-height:1.6;margin:0;}
.frd-how__arrow{align-self:center;font-size:1.4rem;color:rgba(135,35,35,.3);flex-shrink:0;}

/* SOURCES */
.frd-sources{text-align:center;margin-bottom:1.5rem;}
.frd-sources__label{font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--f-red);margin-bottom:.75rem;}
.frd-sources__pills{display:flex;flex-wrap:wrap;gap:.45rem;justify-content:center;}
.frd-pill{padding:.35rem .85rem;border-radius:999px;background:var(--frd-card);border:1px solid var(--frd-border);font-size:.78rem;font-weight:700;color:var(--frd-text3);}

/* FORM SECTION */
.frd-form-section{background:var(--frd-card);border:1px solid var(--frd-border);border-radius:28px;padding:2.5rem;box-shadow:0 16px 56px rgba(0,0,0,.07);margin-bottom:2rem;}
.frd-form-header{text-align:center;margin-bottom:2rem;}
.frd-form-header h2{font-family:'Space Grotesk',sans-serif;font-size:1.8rem;font-weight:900;letter-spacing:-.03em;color:var(--frd-text1);margin:0 0 .5rem;}
.frd-form-header p{font-size:.9rem;color:var(--frd-text3);}
.frd-flash{display:flex;align-items:flex-start;gap:.7rem;padding:1rem 1.25rem;border-radius:14px;margin-bottom:1.5rem;font-size:.9rem;font-weight:600;line-height:1.6;}
.frd-flash--success{background:rgba(5,150,105,.07);border:1px solid rgba(5,150,105,.18);color:#059669;}
.frd-form{display:flex;flex-direction:column;gap:1.25rem;}
.frd-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.frd-field{display:flex;flex-direction:column;gap:.45rem;}
.frd-field label{font-size:.83rem;font-weight:800;color:var(--frd-text2);display:flex;align-items:center;gap:.4rem;}
.frd-field label span{color:var(--f-red);}
.frd-input{width:100%;padding:.85rem 1rem;border:1.5px solid rgba(0,0,0,.1);border-radius:14px;font-size:.92rem;color:var(--frd-text1);background:var(--frd-soft);transition:border-color .2s,box-shadow .2s;outline:none;appearance:none;font-family:inherit;}
html.dark .frd-input{border-color:rgba(255,255,255,.1);background:#111114;color:#f3f4f6;}
.frd-input:focus{border-color:var(--f-red);background:var(--frd-card);box-shadow:0 0 0 4px rgba(135,35,35,.08);}
.frd-input--err{border-color:#dc2626!important;}
.frd-error{font-size:.78rem;color:#dc2626;font-weight:600;}
.frd-toggle-btn{display:inline-flex;align-items:center;gap:.5rem;font-size:.83rem;font-weight:700;color:var(--f-red);background:rgba(135,35,35,.06);border:1px solid rgba(135,35,35,.14);padding:.5rem 1rem;border-radius:10px;cursor:pointer;transition:.2s;}
.frd-toggle-btn:hover{background:rgba(135,35,35,.1);}
.frd-prefs-block{display:flex;flex-direction:column;gap:1rem;padding:1.25rem;background:rgba(135,35,35,.03);border:1px solid rgba(135,35,35,.08);border-radius:16px;}
html.dark .frd-prefs-block{background:rgba(135,35,35,.06);border-color:rgba(135,35,35,.12);}
.frd-submit{display:flex;align-items:center;justify-content:center;gap:.7rem;padding:1.1rem 1.75rem;background:var(--f-red);color:#fff;border:none;border-radius:16px;font-size:1rem;font-weight:800;cursor:pointer;box-shadow:0 8px 32px rgba(135,35,35,.28);transition:.25s var(--f-ease);font-family:inherit;}
.frd-submit:hover{background:#6f1c1c;transform:translateY(-2px);box-shadow:0 14px 40px rgba(135,35,35,.36);}
.frd-form-note{display:flex;align-items:center;justify-content:center;gap:.4rem;font-size:.75rem;color:var(--frd-text3);text-align:center;}

/* FOOTER NAV */
.frd-footer-nav{display:flex;align-items:center;justify-content:center;gap:1rem;margin-top:1rem;flex-wrap:wrap;}
.frd-nav-link{display:inline-flex;align-items:center;gap:.5rem;padding:.8rem 1.3rem;border-radius:12px;text-decoration:none;font-weight:700;font-size:.9rem;border:1px solid var(--frd-border);color:var(--frd-text3);background:var(--frd-card);transition:.25s var(--f-ease);}
.frd-nav-link:hover{border-color:rgba(135,35,35,.2);color:var(--f-red);}
.frd-nav-link--primary{background:var(--f-red);color:#fff;border-color:var(--f-red);box-shadow:0 8px 28px rgba(135,35,35,.22);}
.frd-nav-link--primary:hover{background:#6f1c1c;transform:translateY(-2px);}

@media(max-width:640px){
    .frd-how{flex-direction:column;gap:.75rem;}
    .frd-how__arrow{align-self:center;transform:rotate(90deg);}
    .frd-row-2{grid-template-columns:1fr;}
    .frd-form-section{padding:1.5rem;}
}
</style>
@endpush

@push('scripts')
<script>
function digestForm() {
    return { domain: '{{ old("domain","") }}', showPrefs: false };
}
document.addEventListener('DOMContentLoaded', () => {
    const obs = new IntersectionObserver(entries => entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('is-visible'); obs.unobserve(e.target); } }), {threshold:0.08});
    document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));

    // Canvas background
    const canvas = document.getElementById('rdCanvas');
    if(canvas) {
        const ctx = canvas.getContext('2d');
        let W, H;
        const resize = () => { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; };
        resize(); window.addEventListener('resize', resize);
        const draw = () => {
            ctx.clearRect(0,0,W,H);
            const cx = W/2, cy = H*.38, t = Date.now()*.0003;
            for(let arm=0;arm<2;arm++){
                ctx.beginPath();
                for(let i=0;i<400;i++){
                    const angle=.045*i+t+arm*Math.PI, r=.65*i;
                    if(r>Math.min(W,H)*.55) break;
                    const x=cx+r*Math.cos(angle), y=cy+r*Math.sin(angle)*.38;
                    i===0?ctx.moveTo(x,y):ctx.lineTo(x,y);
                }
                ctx.strokeStyle='rgba(135,35,35,0.05)'; ctx.lineWidth=1; ctx.stroke();
            }
            requestAnimationFrame(draw);
        };
        draw();
    }

    // Submit loading
    document.getElementById('digestForm').addEventListener('submit', () => {
        const btn = document.getElementById('digestSubmitBtn');
        btn.disabled = true;
        btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin .8s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Inscription en cours...';
    });
});
</script>
<style>@keyframes spin{to{transform:rotate(360deg)}}</style>
@endpush
