@extends('layouts.app')
@section('title', 'Simulateur TJM Freelance — Fidow')

@push('styles')
<style>
:root { --fr:#872323; --frd:#6b1c1c; --ease:cubic-bezier(.16,1,.3,1); }

/* ── HERO ── */
.tjm-hero {
    position:relative; overflow:hidden;
    padding:6rem 1.5rem 4rem; text-align:center;
    background:linear-gradient(160deg,#fef7f7 0%,#fff 60%,#fef2f2 100%);
}
html.dark .tjm-hero { background:linear-gradient(160deg,#0f0608 0%,#0c0c0f 60%,#130a0a 100%); }

.tjm-hero__eyebrow {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.3rem .9rem; border-radius:50px; margin-bottom:1.5rem;
    background:rgba(135,35,35,.07); border:1px solid rgba(135,35,35,.15);
    font-size:.72rem; font-weight:700; color:var(--fr); letter-spacing:.05em; text-transform:uppercase;
}
html.dark .tjm-hero__eyebrow { background:rgba(135,35,35,.2); color:#f87171; }

.tjm-hero__h1 {
    font-family:'Space Grotesk',sans-serif;
    font-size:clamp(2rem,5vw,3.6rem); font-weight:800;
    line-height:1.08; letter-spacing:-.035em; color:#111; margin-bottom:1rem;
}
html.dark .tjm-hero__h1 { color:#f3f4f6; }
.tjm-hero__h1 span {
    background:linear-gradient(135deg,var(--fr),#c04040,#e05555);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.tjm-hero__sub {
    max-width:58ch; margin:0 auto 2rem;
    font-size:1.02rem; line-height:1.75; color:#6b7280;
}
html.dark .tjm-hero__sub { color:#9ca3af; }

/* Hero illustration (SVG floating) */
.tjm-hero__illo {
    max-width:320px; margin:0 auto 2rem;
    animation:illoFloat 5s ease-in-out infinite;
    filter:drop-shadow(0 16px 40px rgba(135,35,35,.14));
}
@keyframes illoFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }

/* ── LAYOUT ── */
.tjm-body { max-width:1160px; margin:0 auto; padding:3rem 1.25rem 5rem; }
.tjm-grid {
    display:grid; grid-template-columns:1fr 380px; gap:2rem; align-items:start;
}
@media(max-width:900px){ .tjm-grid{ grid-template-columns:1fr; } }

/* ── PANEL COMMUN ── */
.tjm-panel {
    background:#fff; border-radius:24px;
    border:1.5px solid rgba(0,0,0,.07);
    box-shadow:0 4px 24px rgba(0,0,0,.06);
    overflow:hidden;
}
html.dark .tjm-panel { background:#161619; border-color:rgba(255,255,255,.08); box-shadow:0 4px 24px rgba(0,0,0,.4); }

.tjm-panel__head {
    padding:1.5rem 1.75rem 1.25rem;
    border-bottom:1px solid rgba(0,0,0,.06);
    font-family:'Space Grotesk',sans-serif;
    font-size:1.05rem; font-weight:700; color:#111;
    display:flex; align-items:center; gap:.6rem;
}
html.dark .tjm-panel__head { border-color:rgba(255,255,255,.06); color:#f3f4f6; }
.tjm-panel__head svg { color:var(--fr); flex-shrink:0; }
.tjm-panel__body { padding:1.5rem 1.75rem; }

/* ── FIELDSETS ── */
.tjm-label {
    font-size:.75rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase;
    color:#9ca3af; margin-bottom:.75rem; display:block;
}

/* Country grid */
.tjm-countries {
    display:grid; grid-template-columns:repeat(auto-fill,minmax(130px,1fr)); gap:.5rem;
}
.tjm-country {
    display:flex; align-items:center; gap:.5rem;
    padding:.55rem .75rem; border-radius:10px; cursor:pointer;
    border:1.5px solid rgba(0,0,0,.07); background:transparent;
    font-size:.82rem; font-weight:600; color:#374151; transition:all .18s;
}
html.dark .tjm-country { border-color:rgba(255,255,255,.08); color:#d1d5db; }
.tjm-country:hover { border-color:rgba(135,35,35,.3); color:var(--fr); background:rgba(135,35,35,.04); }
.tjm-country.selected { background:rgba(135,35,35,.08); border-color:rgba(135,35,35,.4); color:var(--fr); font-weight:700; }
html.dark .tjm-country.selected { background:rgba(135,35,35,.2); color:#f87171; border-color:rgba(200,60,60,.5); }
.tjm-country__flag { font-size:1.2rem; flex-shrink:0; }
.tjm-country__base { font-size:.7rem; color:#9ca3af; font-weight:500; margin-top:.1rem; }

/* Stack chips */
.tjm-stacks {
    display:flex; flex-wrap:wrap; gap:.45rem;
}
.tjm-stack {
    display:flex; align-items:center; gap:.35rem;
    padding:.45rem .85rem; border-radius:50px; cursor:pointer;
    border:1.5px solid rgba(0,0,0,.08); background:transparent;
    font-size:.8rem; font-weight:600; color:#374151; transition:all .18s; white-space:nowrap;
}
html.dark .tjm-stack { border-color:rgba(255,255,255,.1); color:#d1d5db; }
.tjm-stack:hover { border-color:rgba(135,35,35,.35); color:var(--fr); }
.tjm-stack.selected { background:var(--fr); color:#fff; border-color:var(--fr); box-shadow:0 4px 12px rgba(135,35,35,.3); }

/* Country badge (code ISO 2 lettres) */
.tjm-country__code {
    flex-shrink:0; width:28px; height:22px; border-radius:4px;
    background:rgba(135,35,35,.1); color:var(--fr);
    font-size:.62rem; font-weight:900; letter-spacing:.02em;
    display:flex; align-items:center; justify-content:center;
    font-family:monospace; border:1px solid rgba(135,35,35,.15);
}
html.dark .tjm-country__code { background:rgba(135,35,35,.2); color:#f87171; border-color:rgba(200,60,60,.25); }
.tjm-country.selected .tjm-country__code { background:rgba(255,255,255,.25); color:#fff; border-color:transparent; }

/* Stack badge (abréviation) */
.tjm-stack-badge {
    flex-shrink:0; width:26px; height:20px; border-radius:4px;
    font-size:.6rem; font-weight:900; letter-spacing:.01em;
    display:flex; align-items:center; justify-content:center;
    font-family:monospace; border:1px solid;
    transition:all .15s;
}
.tjm-stack.selected .tjm-stack-badge { background:rgba(255,255,255,.2) !important; color:#fff !important; border-color:transparent !important; }

/* Experience cards */
.tjm-exps { display:grid; grid-template-columns:repeat(2,1fr); gap:.6rem; }
.tjm-exp {
    padding:1rem; border-radius:14px; cursor:pointer;
    border:1.5px solid rgba(0,0,0,.07); background:transparent;
    text-align:center; transition:all .18s;
}
html.dark .tjm-exp { border-color:rgba(255,255,255,.08); }
.tjm-exp:hover { border-color:rgba(135,35,35,.3); }
.tjm-exp.selected { background:rgba(135,35,35,.08); border-color:rgba(135,35,35,.4); }
html.dark .tjm-exp.selected { background:rgba(135,35,35,.18); border-color:rgba(200,60,60,.5); }
.tjm-exp__level { font-weight:800; font-size:.92rem; color:#111; margin-bottom:.2rem; }
html.dark .tjm-exp__level { color:#f3f4f6; }
.tjm-exp__years { font-size:.75rem; color:#9ca3af; }
.tjm-exp.selected .tjm-exp__level { color:var(--fr); }
html.dark .tjm-exp.selected .tjm-exp__level { color:#f87171; }

/* Niveau dots */
.tjm-exp__dots { display:flex; gap:3px; justify-content:center; margin-bottom:.5rem; }
.tjm-exp__dot {
    width:8px; height:8px; border-radius:50%;
    background:rgba(135,35,35,.12); border:1px solid rgba(135,35,35,.15);
    transition:all .2s;
}
.tjm-exp__dot.on { background:var(--fr); border-color:var(--fr); }
.tjm-exp.selected .tjm-exp__dot.on { background:#fff; border-color:rgba(255,255,255,.6); }
html.dark .tjm-exp__dot { background:rgba(200,60,60,.1); border-color:rgba(200,60,60,.15); }
html.dark .tjm-exp__dot.on { background:#f87171; border-color:#f87171; }

/* Slider */
.tjm-slider-wrap { display:flex; align-items:center; gap:1rem; }
.tjm-slider {
    flex:1; -webkit-appearance:none; appearance:none;
    height:6px; border-radius:3px; outline:none; cursor:pointer;
    background:linear-gradient(to right, var(--fr) 0%, var(--fr) var(--val, 67%), rgba(135,35,35,.15) var(--val, 67%));
}
.tjm-slider::-webkit-slider-thumb {
    -webkit-appearance:none; width:20px; height:20px; border-radius:50%;
    background:var(--fr); cursor:pointer;
    box-shadow:0 2px 8px rgba(135,35,35,.4);
    border:3px solid white;
    transition:transform .15s;
}
.tjm-slider::-webkit-slider-thumb:hover { transform:scale(1.2); }
.tjm-slider-val {
    width:48px; text-align:right;
    font-size:.9rem; font-weight:800; color:var(--fr);
}

/* ── RÉSULTATS ── */
.tjm-result-panel { position:sticky; top:5.5rem; }

.tjm-tjm-main {
    text-align:center; padding:1.75rem 1.5rem 1.5rem;
    border-bottom:1px solid rgba(0,0,0,.06);
}
html.dark .tjm-tjm-main { border-color:rgba(255,255,255,.06); }

.tjm-tjm-label { font-size:.72rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#9ca3af; margin-bottom:.5rem; }
.tjm-tjm-value {
    font-family:'Space Grotesk',sans-serif;
    font-size:3.5rem; font-weight:900; line-height:1;
    color:var(--fr); margin-bottom:.25rem;
    transition:all .3s var(--ease);
}
html.dark .tjm-tjm-value { color:#f87171; }
.tjm-tjm-unit { font-size:1.1rem; font-weight:600; color:#9ca3af; margin-bottom:1rem; }

.tjm-range {
    display:flex; align-items:center; justify-content:center; gap:.75rem;
    font-size:.8rem;
}
.tjm-range__item { text-align:center; }
.tjm-range__n { font-weight:800; color:#374151; }
html.dark .tjm-range__n { color:#d1d5db; }
.tjm-range__l { color:#9ca3af; font-size:.7rem; }
.tjm-range__sep { width:1px; height:28px; background:rgba(0,0,0,.08); }
html.dark .tjm-range__sep { background:rgba(255,255,255,.08); }

/* Income breakdown */
.tjm-incomes { padding:1.25rem 1.5rem; border-bottom:1px solid rgba(0,0,0,.06); }
html.dark .tjm-incomes { border-color:rgba(255,255,255,.06); }
.tjm-income { display:flex; align-items:center; justify-content:space-between; margin-bottom:.75rem; }
.tjm-income:last-child { margin-bottom:0; }
.tjm-income__label { display:flex; align-items:center; gap:.4rem; font-size:.83rem; color:#6b7280; }
html.dark .tjm-income__label { color:#9ca3af; }
.tjm-income__label svg { flex-shrink:0; }
.tjm-income__val { font-weight:800; font-size:.9rem; color:#111; }
html.dark .tjm-income__val { color:#f3f4f6; }

/* Market bar chart */
.tjm-market { padding:1.25rem 1.5rem; }
.tjm-market__title { font-size:.72rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af; margin-bottom:1rem; }
.tjm-market__bar { margin-bottom:.65rem; }
.tjm-market__bar-label { display:flex; justify-content:space-between; font-size:.78rem; margin-bottom:.3rem; color:#6b7280; }
html.dark .tjm-market__bar-label { color:#9ca3af; }
.tjm-market__bar-label strong { color:#111; font-weight:700; }
html.dark .tjm-market__bar-label strong { color:#f3f4f6; }
.tjm-market__track { height:8px; border-radius:4px; background:rgba(135,35,35,.08); overflow:hidden; }
html.dark .tjm-market__track { background:rgba(255,255,255,.06); }
.tjm-market__fill {
    height:100%; border-radius:4px;
    transition:width .6s var(--ease);
}
.tjm-market__fill--you { background:linear-gradient(90deg,var(--fr),#c04040); }
.tjm-market__fill--med { background:rgba(135,35,35,.3); }
.tjm-market__fill--jun { background:rgba(135,35,35,.15); }

/* Tip box */
.tjm-tip {
    margin:0 1.5rem 1.5rem; padding:1rem 1.1rem;
    background:rgba(135,35,35,.05); border:1px solid rgba(135,35,35,.12);
    border-radius:12px; font-size:.8rem; line-height:1.6; color:#374151;
}
html.dark .tjm-tip { background:rgba(135,35,35,.12); border-color:rgba(200,60,60,.2); color:#d1d5db; }

/* Divider section */
.tjm-section-gap { height:2rem; }

/* ── FAQ ── */
.tjm-faq { max-width:680px; margin:0 auto; padding:0 1.25rem 5rem; }
.tjm-faq__title {
    font-family:'Space Grotesk',sans-serif;
    font-size:1.5rem; font-weight:800; color:#111;
    text-align:center; margin-bottom:2rem;
}
html.dark .tjm-faq__title { color:#f3f4f6; }
.tjm-faq__item {
    border-bottom:1px solid rgba(0,0,0,.07);
    padding:.75rem 0;
}
html.dark .tjm-faq__item { border-color:rgba(255,255,255,.07); }
.tjm-faq__q {
    display:flex; justify-content:space-between; align-items:center;
    cursor:pointer; font-weight:600; font-size:.92rem; color:#111;
    gap:.5rem; padding:.25rem 0;
}
html.dark .tjm-faq__q { color:#e5e7eb; }
.tjm-faq__q svg { flex-shrink:0; transition:transform .25s; color:#9ca3af; }
.tjm-faq__a {
    font-size:.875rem; line-height:1.7; color:#6b7280; padding:.5rem 0 .25rem;
    display:none;
}
html.dark .tjm-faq__a { color:#9ca3af; }
.tjm-faq__item.open .tjm-faq__q svg { transform:rotate(180deg); }
.tjm-faq__item.open .tjm-faq__a { display:block; }
</style>
@endpush

@section('content')

<!-- ── HERO ── -->
<section class="tjm-hero">
    <div class="tjm-hero__illo">
        <img src="{{ asset('assets/2.webp') }}"
             alt="Simulateur TJM — Calcule ton tarif freelance"
             width="340" height="340"
             style="max-width:340px;width:100%;height:auto;border-radius:24px;box-shadow:0 24px 60px rgba(135,35,35,.2);">
    </div>
    <div class="tjm-hero__eyebrow">
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        Simulateur de Tarif
    </div>
    <h1 class="tjm-hero__h1">Calcule ton <span>TJM freelance</span><br>en 30 secondes</h1>
    <p class="tjm-hero__sub">Pays, stack technique, expérience — configure tes paramètres et obtiens une fourchette réaliste pour ton tarif journalier, mensuel et annuel.</p>
</section>

<!-- ── CALCULATEUR ── -->
<div class="tjm-body" x-data="tjmCalc()">
<div class="tjm-grid">

    <!-- ── PANNEAU GAUCHE : CONFIGURATEUR ── -->
    <div class="space-y-4">

        <!-- Pays -->
        <div class="tjm-panel">
            <div class="tjm-panel__head">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                Où es-tu basé(e) ?
            </div>
            <div class="tjm-panel__body">
                <div class="tjm-countries">
                    <template x-for="c in countries" :key="c.id">
                        <button type="button"
                            class="tjm-country"
                            :class="{ selected: country === c.id }"
                            @click="country = c.id">
                            <span class="tjm-country__code" x-text="c.code"></span>
                            <div>
                                <div x-text="c.name"></div>
                                <div class="tjm-country__base" x-text="'~' + c.base + '€/j base'"></div>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Stack -->
        <div class="tjm-panel">
            <div class="tjm-panel__head">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                Ta spécialisation principale
            </div>
            <div class="tjm-panel__body">
                <div class="tjm-stacks">
                    <template x-for="s in stacks" :key="s.id">
                        <button type="button"
                            class="tjm-stack"
                            :class="{ selected: stack === s.id }"
                            @click="stack = s.id">
                            <span class="tjm-stack-badge"
                                  :style="`background:${s.color}15;color:${s.color};border-color:${s.color}30`"
                                  x-text="s.abbr"></span>
                            <span x-text="s.name"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Expérience -->
        <div class="tjm-panel">
            <div class="tjm-panel__head">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Niveau d'expérience
            </div>
            <div class="tjm-panel__body">
                <div class="tjm-exps">
                    <template x-for="e in experiences" :key="e.id">
                        <button type="button"
                            class="tjm-exp"
                            :class="{ selected: experience === e.id }"
                            @click="experience = e.id">
                            <div class="tjm-exp__dots">
                                <template x-for="i in [1,2,3,4]" :key="i">
                                    <div class="tjm-exp__dot" :class="{ on: i <= e.dots }"></div>
                                </template>
                            </div>
                            <div class="tjm-exp__level" x-text="e.name"></div>
                            <div class="tjm-exp__years" x-text="e.years"></div>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Jours de travail -->
        <div class="tjm-panel">
            <div class="tjm-panel__head">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Jours facturés / mois
            </div>
            <div class="tjm-panel__body">
                <div class="tjm-slider-wrap">
                    <input type="range" min="10" max="23" x-model="workDays" class="tjm-slider"
                        :style="`--val:${((workDays-10)/13)*100}%`">
                    <div class="tjm-slider-val" x-text="workDays + 'j'"></div>
                </div>
                <p style="font-size:.77rem;color:#9ca3af;margin-top:.5rem;">
                    Recommandé : 18-20j (congés, admin, prospection)
                </p>
            </div>
        </div>
    </div>

    <!-- ── PANNEAU DROIT : RÉSULTATS ── -->
    <div class="tjm-result-panel">
        <div class="tjm-panel">
            <!-- TJM principal -->
            <div class="tjm-tjm-main">
                <div class="tjm-tjm-label">Votre TJM cible</div>
                <div class="tjm-tjm-value" x-text="fmt(tjmTarget) + ' €'"></div>
                <div class="tjm-tjm-unit">par jour</div>
                <div class="tjm-range">
                    <div class="tjm-range__item">
                        <div class="tjm-range__n" x-text="fmt(tjmMin) + '€'"></div>
                        <div class="tjm-range__l">Minimum</div>
                    </div>
                    <div class="tjm-range__sep"></div>
                    <div class="tjm-range__item">
                        <div class="tjm-range__n" x-text="fmt(tjmTarget) + '€'"></div>
                        <div class="tjm-range__l">Cible</div>
                    </div>
                    <div class="tjm-range__sep"></div>
                    <div class="tjm-range__item">
                        <div class="tjm-range__n" x-text="fmt(tjmMax) + '€'"></div>
                        <div class="tjm-range__l">Maximum</div>
                    </div>
                </div>
            </div>

            <!-- Revenus -->
            <div class="tjm-incomes">
                <div class="tjm-income">
                    <div class="tjm-income__label">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Revenu mensuel brut
                    </div>
                    <div class="tjm-income__val" x-text="fmt(monthlyTarget) + ' €'"></div>
                </div>
                <div class="tjm-income">
                    <div class="tjm-income__label">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Revenu annuel estimé
                    </div>
                    <div class="tjm-income__val" x-text="fmt(annualTarget) + ' €'"></div>
                </div>
                <div class="tjm-income">
                    <div class="tjm-income__label">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        TJM × jours facturés
                    </div>
                    <div class="tjm-income__val" x-text="workDays + 'j × ' + fmt(tjmTarget) + '€'"></div>
                </div>
            </div>

            <!-- Comparaison marché -->
            <div class="tjm-market">
                <div class="tjm-market__title">Positionnement marché</div>
                <div class="tjm-market__bar">
                    <div class="tjm-market__bar-label">
                        <strong>Toi</strong>
                        <span x-text="fmt(tjmTarget) + ' €'"></span>
                    </div>
                    <div class="tjm-market__track">
                        <div class="tjm-market__fill tjm-market__fill--you"
                             :style="`width:${Math.min((tjmTarget/marketMax)*100,100)}%`"></div>
                    </div>
                </div>
                <div class="tjm-market__bar">
                    <div class="tjm-market__bar-label">
                        <span>Médiane marché</span>
                        <span x-text="fmt(marketMedian) + ' €'"></span>
                    </div>
                    <div class="tjm-market__track">
                        <div class="tjm-market__fill tjm-market__fill--med"
                             :style="`width:${(marketMedian/marketMax)*100}%`"></div>
                    </div>
                </div>
                <div class="tjm-market__bar">
                    <div class="tjm-market__bar-label">
                        <span>Junior du même pays</span>
                        <span x-text="fmt(marketJunior) + ' €'"></span>
                    </div>
                    <div class="tjm-market__track">
                        <div class="tjm-market__fill tjm-market__fill--jun"
                             :style="`width:${(marketJunior/marketMax)*100}%`"></div>
                    </div>
                </div>
            </div>

            <!-- Conseil -->
            <div class="tjm-tip" x-text="activeTip"></div>
        </div>
    </div>
</div>
</div>

<!-- ── FAQ ── -->
<div class="tjm-faq">
    <h2 class="tjm-faq__title">Questions fréquentes</h2>

    <div class="tjm-faq__item">
        <div class="tjm-faq__q" onclick="this.closest('.tjm-faq__item').classList.toggle('open')">
            <span>Comment est calculé mon TJM ?</span>
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
        <div class="tjm-faq__a">Le TJM est calculé à partir d'un taux de base selon ton pays de résidence, multiplié par un coefficient lié à ta stack (les compétences rares valent plus) et par un coefficient d'expérience. C'est une estimation basée sur les données du marché freelance — ajuste en fonction de ta réalité.</div>
    </div>

    <div class="tjm-faq__item">
        <div class="tjm-faq__q" onclick="this.closest('.tjm-faq__item').classList.toggle('open')">
            <span>Le TJM inclut-il les charges ?</span>
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
        <div class="tjm-faq__a">Non, le TJM affiché est le tarif brut à facturer au client. En France par exemple, il faut ensuite déduire les charges sociales (~22-45% selon le statut), les frais professionnels et se garder une réserve. Multiplie par 0.55-0.7 pour estimer ton revenu net annuel.</div>
    </div>

    <div class="tjm-faq__item">
        <div class="tjm-faq__q" onclick="this.closest('.tjm-faq__item').classList.toggle('open')">
            <span>Mon TJM est trop bas, comment le négocier ?</span>
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
        <div class="tjm-faq__a">Utilise le Générateur de Positionnement de Fidow pour créer une phrase d'accroche percutante qui justifie ton tarif. Documente tes réalisations avec des chiffres concrets (ex. "réduit le temps de chargement de 40%"). Propose un premier projet à petit TJM pour construire ta réputation, puis augmente progressivement.</div>
    </div>

    <div class="tjm-faq__item">
        <div class="tjm-faq__q" onclick="this.closest('.tjm-faq__item').classList.toggle('open')">
            <span>Pourquoi les TJM varient autant selon les pays ?</span>
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
        <div class="tjm-faq__a">Le coût de la vie, le pouvoir d'achat des clients locaux et la compétitivité du marché varient fortement. Un freelance basé en Afrique peut proposer des tarifs compétitifs à des clients internationaux (Europe/USA) et générer un excellent niveau de vie localement — c'est l'avantage géographique du remote.</div>
    </div>
</div>

@push('scripts')
<script>
function tjmCalc() {
    return {
        country: 'benin',
        stack: 'backend',
        experience: 'mid',
        workDays: 20,

        countries: [
            // ── Afrique de l'Ouest (priorité) ─────────────────────────
            { id:'benin',    name:'Bénin',         code:'BJ', base:130 },
            { id:'civ',      name:"Côte d'Ivoire", code:'CI', base:165 },
            { id:'senegal',  name:'Sénégal',       code:'SN', base:155 },
            { id:'togo',     name:'Togo',          code:'TG', base:120 },
            { id:'ghana',    name:'Ghana',         code:'GH', base:140 },
            { id:'nigeria',  name:'Nigeria',       code:'NG', base:175 },
            { id:'burkina',  name:'Burkina Faso',  code:'BF', base:115 },
            { id:'cameroun', name:'Cameroun',      code:'CM', base:145 },
            { id:'mali',     name:'Mali',          code:'ML', base:115 },
            { id:'maroc',    name:'Maroc',         code:'MA', base:200 },
            // ── Europe & international ─────────────────────────────────
            { id:'france',   name:'France',        code:'FR', base:550 },
            { id:'belgique', name:'Belgique',      code:'BE', base:500 },
            { id:'suisse',   name:'Suisse',        code:'CH', base:900 },
            { id:'canada',   name:'Canada',        code:'CA', base:620 },
            { id:'allemagne',name:'Allemagne',     code:'DE', base:650 },
            { id:'usa',      name:'États-Unis',    code:'US', base:820 },
            { id:'other',    name:'Autre pays',    code:'WW', base:300 },
        ],

        stacks: [
            { id:'ai_ml',      name:'IA / ML',              abbr:'AI', color:'#7c3aed', mult:1.45 },
            { id:'blockchain', name:'Blockchain / Web3',    abbr:'BC', color:'#0891b2', mult:1.50 },
            { id:'devops',     name:'DevOps / Cloud',       abbr:'DO', color:'#0284c7', mult:1.35 },
            { id:'cyber',      name:'Cybersécurité',        abbr:'SC', color:'#dc2626', mult:1.30 },
            { id:'data',       name:'Data / Analytics',     abbr:'DA', color:'#d97706', mult:1.25 },
            { id:'mobile',     name:'Mobile (Flutter/RN)',  abbr:'MB', color:'#16a34a', mult:1.20 },
            { id:'fullstack',  name:'Fullstack',            abbr:'FS', color:'#872323', mult:1.15 },
            { id:'backend',    name:'Backend (Laravel/Node)',abbr:'BE', color:'#c2410c', mult:1.10 },
            { id:'frontend',   name:'Frontend (React/Vue)', abbr:'FE', color:'#0ea5e9', mult:1.00 },
            { id:'design',     name:'UX/UI Design',         abbr:'UX', color:'#db2777', mult:0.95 },
            { id:'pm',         name:'Product / PM',         abbr:'PM', color:'#059669', mult:1.05 },
            { id:'marketing',  name:'Marketing Digital',    abbr:'MK', color:'#ca8a04', mult:0.85 },
        ],

        experiences: [
            { id:'junior',  name:'Junior',        years:'0–2 ans',  dots:1, mult:0.65 },
            { id:'mid',     name:'Intermédiaire', years:'3–5 ans',  dots:2, mult:1.00 },
            { id:'senior',  name:'Senior',        years:'6–10 ans', dots:3, mult:1.35 },
            { id:'expert',  name:'Expert',        years:'10+ ans',  dots:4, mult:1.60 },
        ],

        get baseRate() {
            return (this.countries.find(c => c.id === this.country) || {base:400}).base;
        },
        get stackMult() {
            return (this.stacks.find(s => s.id === this.stack) || {mult:1}).mult;
        },
        get expMult() {
            return (this.experiences.find(e => e.id === this.experience) || {mult:1}).mult;
        },

        get tjmTarget() { return Math.round(this.baseRate * this.stackMult * this.expMult); },
        get tjmMin()    { return Math.round(this.tjmTarget * 0.80); },
        get tjmMax()    { return Math.round(this.tjmTarget * 1.28); },

        get monthlyTarget() { return this.tjmTarget * this.workDays; },
        get annualTarget()  { return Math.round(this.monthlyTarget * 11); },

        get marketMedian() { return Math.round(this.baseRate * this.stackMult * 1.0); },
        get marketJunior() { return Math.round(this.baseRate * this.stackMult * 0.65); },
        get marketMax()    { return Math.max(this.tjmMax, this.marketMedian) * 1.1; },

        get activeTip() {
            const e = this.experience;
            const s = this.stack;
            const aof = ['benin','civ','senegal','togo','ghana','nigeria','burkina','cameroun','mali'];
            if (e === 'junior') return 'Conseil : En junior, concentre-toi sur 1–2 spécialités pointues plutôt que généraliste — c\'est la clé pour augmenter ton TJM rapidement.';
            if (s === 'ai_ml' || s === 'blockchain') return 'Demande forte : Ta spécialisation est très recherchée en ce moment. Documente tes projets avec des métriques concrètes pour justifier ce tarif premium.';
            if (aof.includes(this.country)) return 'Avantage géo : Depuis l\'Afrique de l\'Ouest, tu peux proposer des tarifs compétitifs à des clients européens et générer un excellent pouvoir d\'achat local. C\'est ton levier principal.';
            if (e === 'expert') return 'Niveau expert : Tes clients paient pour ton jugement, pas tes heures. Pense à proposer des forfaits résultats ou du conseil stratégique.';
            return 'Pour augmenter ton TJM : spécialise-toi sur un secteur vertical (fintech, santé, e-commerce) en plus de ta stack technique.';
        },

        fmt(n) {
            return new Intl.NumberFormat('fr-FR').format(n);
        }
    }
}
</script>
@endpush

@endsection
