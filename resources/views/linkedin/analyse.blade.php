@extends('layouts.app')
@section('title', 'Analyse IA de Profil LinkedIn — Fidow')

@push('styles')
<style>
:root { --li:#0a66c2; --fr:#872323; --gold:#d97706; --ease:cubic-bezier(.16,1,.3,1); }

/* ══════════ HERO ══════════ */
.li-page { min-height:100vh; }

.li-hero {
    position:relative; overflow:hidden;
    background:linear-gradient(160deg,#f0f7ff 0%,#fff 50%,#fef7f7 100%);
    padding:5.5rem 1.5rem 0;
}
html.dark .li-hero {
    background:linear-gradient(160deg,#080d14 0%,#0c0c0f 50%,#0f0608 100%);
}

/* Mesh gradient background */
.li-hero__mesh {
    position:absolute; inset:0; pointer-events:none; overflow:hidden;
}
.li-hero__mesh::before {
    content:''; position:absolute;
    width:600px; height:500px; border-radius:50%;
    background:radial-gradient(ellipse,rgba(10,102,194,.12) 0%,transparent 70%);
    top:-100px; right:-100px;
    animation:meshFloat 18s ease-in-out infinite;
}
.li-hero__mesh::after {
    content:''; position:absolute;
    width:400px; height:350px; border-radius:50%;
    background:radial-gradient(ellipse,rgba(135,35,35,.1) 0%,transparent 70%);
    bottom:0; left:-80px;
    animation:meshFloat 22s ease-in-out infinite reverse;
}
html.dark .li-hero__mesh::before { background:radial-gradient(ellipse,rgba(10,102,194,.25) 0%,transparent 70%); }
html.dark .li-hero__mesh::after  { background:radial-gradient(ellipse,rgba(135,35,35,.22) 0%,transparent 70%); }
@keyframes meshFloat { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(30px,-40px) scale(1.08)} }

.li-hero__inner {
    position:relative; z-index:1;
    max-width:1100px; margin:0 auto;
    display:grid; grid-template-columns:1fr 440px; gap:4rem; align-items:end;
    padding-bottom:0;
}
@media(max-width:900px){ .li-hero__inner{ grid-template-columns:1fr; gap:2.5rem; } }

.li-hero__text { padding-bottom:3rem; }

.li-hero__badge {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.3rem 1rem; border-radius:50px; margin-bottom:1.75rem;
    background:rgba(10,102,194,.07); border:1px solid rgba(10,102,194,.2);
    font-size:.72rem; font-weight:800; color:var(--li); letter-spacing:.06em; text-transform:uppercase;
}
html.dark .li-hero__badge { background:rgba(10,102,194,.15); color:#60a5fa; border-color:rgba(96,165,250,.25); }

.li-hero__h1 {
    font-family:'Space Grotesk',sans-serif;
    font-size:clamp(2rem,4.5vw,3.5rem); font-weight:900;
    line-height:1.06; letter-spacing:-.04em; color:#0a0a0a; margin-bottom:1rem;
}
html.dark .li-hero__h1 { color:#f3f4f6; }
.li-hero__h1 .li-accent {
    background:linear-gradient(135deg,var(--li) 0%,#0891b2 60%,#06b6d4 100%);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.li-hero__h1 .li-accent-2 {
    background:linear-gradient(135deg,var(--fr),#c04040);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}

.li-hero__sub { font-size:1.05rem; line-height:1.75; color:#6b7280; max-width:52ch; margin-bottom:2rem; }
html.dark .li-hero__sub { color:#9ca3af; }

/* Trust badges */
.li-trust { display:flex; gap:1rem; flex-wrap:wrap; }
.li-trust__item {
    display:flex; align-items:center; gap:.4rem;
    font-size:.78rem; font-weight:600; color:#374151;
    background:#fff; border:1px solid rgba(0,0,0,.07);
    padding:.35rem .8rem; border-radius:50px;
    box-shadow:0 1px 8px rgba(0,0,0,.05);
}
html.dark .li-trust__item { background:#161619; border-color:rgba(255,255,255,.08); color:#d1d5db; }
.li-trust__dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
.li-trust__dot--blue  { background:#0a66c2; }
.li-trust__dot--green { background:#22c55e; }
.li-trust__dot--gold  { background:#d97706; }

/* Hero illustration — mockup animé */
.li-hero__mockup {
    position:relative; align-self:end;
}
@media(max-width:900px){ .li-hero__mockup{ max-width:420px; margin:0 auto; } }

.li-mockup-card {
    background:#fff; border-radius:20px;
    border:1.5px solid rgba(10,102,194,.12);
    box-shadow:0 24px 80px rgba(10,102,194,.15), 0 4px 16px rgba(0,0,0,.06);
    padding:1.5rem; overflow:hidden;
    transform:perspective(1000px) rotateY(-4deg) rotateX(2deg);
    animation:mockupFloat 6s ease-in-out infinite;
}
html.dark .li-mockup-card {
    background:#161619; border-color:rgba(96,165,250,.2);
    box-shadow:0 24px 80px rgba(10,102,194,.25), 0 4px 16px rgba(0,0,0,.5);
}
@keyframes mockupFloat { 0%,100%{transform:perspective(1000px) rotateY(-4deg) rotateX(2deg) translateY(0)} 50%{transform:perspective(1000px) rotateY(-4deg) rotateX(2deg) translateY(-12px)} }

/* Profile header mock */
.li-mock-banner {
    height:60px; border-radius:12px; margin:-1.5rem -1.5rem 0;
    background:linear-gradient(135deg,rgba(10,102,194,.15),rgba(10,102,194,.05));
    margin-bottom:0;
}
.li-mock-profile { display:flex; align-items:flex-end; gap:.75rem; margin-top:-20px; padding:0 .5rem; margin-bottom:1rem; }
.li-mock-av {
    width:52px; height:52px; border-radius:50%; border:3px solid white;
    background:linear-gradient(135deg,var(--li),#0284c7);
    display:flex; align-items:center; justify-content:center; color:white; font-weight:800; font-size:1.1rem;
    flex-shrink:0;
}
html.dark .li-mock-av { border-color:#161619; }
.li-mock-name { font-weight:800; font-size:.88rem; color:#111; }
html.dark .li-mock-name { color:#f3f4f6; }
.li-mock-title { font-size:.72rem; color:#6b7280; }

/* Score ring */
.li-mock-score-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:.85rem; }
.li-mock-score {
    width:64px; height:64px; border-radius:50%; flex-shrink:0;
    background:conic-gradient(var(--li) 0% 75%, rgba(10,102,194,.1) 75%);
    display:flex; align-items:center; justify-content:center; position:relative;
    animation:ringGrow 1.5s var(--ease) both 0.5s;
}
@keyframes ringGrow { from{background:conic-gradient(var(--li) 0% 0%,rgba(10,102,194,.1) 0%)} }
.li-mock-score__inner {
    position:absolute; inset:7px; border-radius:50%; background:white;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
}
html.dark .li-mock-score__inner { background:#161619; }
.li-mock-score__n { font-weight:900; font-size:.95rem; color:var(--li); line-height:1; }
.li-mock-score__l { font-size:.5rem; color:#9ca3af; font-weight:600; }

/* Category bars in mock */
.li-mock-bar { margin-bottom:.5rem; }
.li-mock-bar__top { display:flex; justify-content:space-between; font-size:.65rem; color:#6b7280; margin-bottom:.2rem; }
html.dark .li-mock-bar__top { color:#9ca3af; }
.li-mock-bar__track { height:5px; border-radius:2.5px; background:rgba(10,102,194,.08); overflow:hidden; }
html.dark .li-mock-bar__track { background:rgba(96,165,250,.08); }
.li-mock-bar__fill { height:100%; border-radius:2.5px; animation:barGrowMock .9s var(--ease) both; }
@keyframes barGrowMock { from{width:0} }
.li-mock-bar__fill--1 { background:linear-gradient(90deg,#0a66c2,#0284c7); width:82%; animation-delay:.6s; }
.li-mock-bar__fill--2 { background:linear-gradient(90deg,#16a34a,#22c55e); width:67%; animation-delay:.75s; }
.li-mock-bar__fill--3 { background:linear-gradient(90deg,#d97706,#f59e0b); width:55%; animation-delay:.9s; }
.li-mock-bar__fill--4 { background:linear-gradient(90deg,#0a66c2,#0284c7); width:90%; animation-delay:1.05s; }

/* Phrase badge in mock */
.li-mock-phrase {
    margin-top:.85rem; padding:.65rem .85rem; border-radius:10px;
    background:rgba(10,102,194,.06); border:1px solid rgba(10,102,194,.15);
    font-size:.7rem; line-height:1.5; color:#374151; font-style:italic;
}
html.dark .li-mock-phrase { background:rgba(10,102,194,.1); color:#d1d5db; border-color:rgba(96,165,250,.2); }

/* Floating badges */
.li-float-badge {
    position:absolute; padding:.4rem .85rem; border-radius:50px;
    font-size:.72rem; font-weight:700; box-shadow:0 8px 24px rgba(0,0,0,.12);
    white-space:nowrap; animation:badgeFloat 4s ease-in-out infinite;
}
.li-float-badge--1 {
    background:#fff; color:#16a34a; border:1px solid rgba(34,197,94,.2);
    right:-20px; top:30%; animation-delay:0s;
}
html.dark .li-float-badge--1 { background:#1a1a1d; }
.li-float-badge--2 {
    background:#fff; color:var(--li); border:1px solid rgba(10,102,194,.2);
    left:-20px; bottom:20%; animation-delay:1.5s;
}
html.dark .li-float-badge--2 { background:#1a1a1d; }
@keyframes badgeFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

/* ══════════ FORM SECTION ══════════ */
.li-form-section { max-width:780px; margin:0 auto; padding:3.5rem 1.25rem 4rem; }

/* Tabs */
.li-tabs {
    display:flex; gap:.5rem; padding:.35rem; border-radius:16px;
    background:rgba(0,0,0,.04); border:1px solid rgba(0,0,0,.07);
    margin-bottom:1.75rem;
}
html.dark .li-tabs { background:rgba(255,255,255,.04); border-color:rgba(255,255,255,.07); }
.li-tab {
    flex:1; padding:.65rem 1rem; border-radius:12px; border:none; cursor:pointer;
    font-size:.875rem; font-weight:600; color:#6b7280; background:transparent;
    transition:all .2s; display:flex; align-items:center; justify-content:center; gap:.4rem;
}
html.dark .li-tab { color:#9ca3af; }
.li-tab.active {
    background:#fff; color:#111; box-shadow:0 2px 12px rgba(0,0,0,.08);
}
html.dark .li-tab.active { background:#1a1a1d; color:#f3f4f6; box-shadow:0 2px 12px rgba(0,0,0,.4); }
.li-tab svg { flex-shrink:0; }

/* Form card */
.li-form-card {
    background:#fff; border-radius:24px;
    border:1.5px solid rgba(0,0,0,.07);
    box-shadow:0 8px 40px rgba(0,0,0,.06);
    padding:2rem;
}
html.dark .li-form-card { background:#161619; border-color:rgba(255,255,255,.08); box-shadow:0 8px 40px rgba(0,0,0,.4); }

/* URL input */
.li-url-wrap {
    display:flex; align-items:center;
    border:1.5px solid rgba(10,102,194,.25); border-radius:14px;
    overflow:hidden; background:#fff; transition:border-color .2s, box-shadow .2s;
}
html.dark .li-url-wrap { background:#111114; border-color:rgba(96,165,250,.2); }
.li-url-wrap:focus-within { border-color:var(--li); box-shadow:0 0 0 3px rgba(10,102,194,.1); }
.li-url-icon {
    flex-shrink:0; width:52px; height:52px;
    background:rgba(10,102,194,.06);
    display:flex; align-items:center; justify-content:center;
    border-right:1px solid rgba(10,102,194,.12);
}
html.dark .li-url-icon { background:rgba(10,102,194,.12); border-right-color:rgba(96,165,250,.15); }
.li-url-input {
    flex:1; padding:0 1rem; height:52px; border:none; outline:none;
    font-size:.9rem; color:#111; background:transparent;
}
html.dark .li-url-input { color:#f3f4f6; }
.li-url-input::placeholder { color:#9ca3af; font-size:.85rem; }

.li-url-hint { font-size:.75rem; color:#9ca3af; margin-top:.5rem; }

/* Textarea */
.li-textarea {
    width:100%; min-height:200px; padding:1rem 1.2rem;
    border-radius:14px; border:1.5px solid rgba(0,0,0,.09);
    background:#fafafa; font-size:.875rem; line-height:1.7;
    color:#374151; resize:vertical; outline:none; font-family:inherit;
    transition:border-color .2s, box-shadow .2s;
}
html.dark .li-textarea { background:#111114; border-color:rgba(255,255,255,.07); color:#d1d5db; }
.li-textarea:focus { border-color:rgba(10,102,194,.4); box-shadow:0 0 0 3px rgba(10,102,194,.08); }

/* Tips chips */
.li-chips { display:flex; flex-wrap:wrap; gap:.4rem; margin:1rem 0 1.5rem; }
.li-chip {
    padding:.28rem .7rem; border-radius:50px; font-size:.73rem; font-weight:600;
    background:rgba(10,102,194,.06); color:#0a66c2; border:1px solid rgba(10,102,194,.15);
}
html.dark .li-chip { background:rgba(10,102,194,.12); color:#60a5fa; }

/* Submit btn */
.li-submit {
    width:100%; padding:.9rem; border-radius:14px; border:none; cursor:pointer;
    background:linear-gradient(135deg,var(--li),#0284c7);
    color:#fff; font-weight:700; font-size:.95rem; letter-spacing:.01em;
    display:flex; align-items:center; justify-content:center; gap:.5rem;
    transition:all .25s var(--ease); box-shadow:0 4px 20px rgba(10,102,194,.35);
    margin-top:1.5rem;
}
.li-submit:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(10,102,194,.45); }
.li-submit:disabled { opacity:.55; cursor:not-allowed; transform:none; }

.li-error-box {
    padding:.75rem 1rem; border-radius:12px; margin-bottom:1rem;
    background:rgba(220,38,38,.06); border:1px solid rgba(220,38,38,.18);
    color:#dc2626; font-size:.875rem;
}

/* Loading */
.li-loading {
    display:none; padding:2.5rem; text-align:center;
}
.li-loading.show { display:block; }
.li-loading__steps { display:flex; flex-direction:column; gap:.75rem; max-width:320px; margin:1.5rem auto 0; }
.li-loading__step {
    display:flex; align-items:center; gap:.6rem;
    font-size:.82rem; color:#6b7280; padding:.5rem .75rem; border-radius:10px;
    background:rgba(10,102,194,.04); transition:all .4s;
}
html.dark .li-loading__step { color:#9ca3af; background:rgba(10,102,194,.08); }
.li-loading__step.active { color:var(--li); background:rgba(10,102,194,.08); font-weight:600; }
html.dark .li-loading__step.active { color:#60a5fa; }
.li-loading__step.done { color:#16a34a; background:rgba(34,197,94,.06); }
.li-step-dot {
    width:8px; height:8px; border-radius:50%; flex-shrink:0;
    background:rgba(10,102,194,.2);
}
.li-loading__step.active .li-step-dot { background:var(--li); animation:stepPulse 1s ease-in-out infinite; }
.li-loading__step.done .li-step-dot { background:#16a34a; }
@keyframes stepPulse { 0%,100%{opacity:1} 50%{opacity:.4} }

/* Spinner */
.li-spinner {
    width:48px; height:48px; border-radius:50%;
    border:4px solid rgba(10,102,194,.12); border-top-color:var(--li);
    animation:spin 1s linear infinite; margin:0 auto;
}
@keyframes spin { to{transform:rotate(360deg)} }

/* ══════════ RESULTS ══════════ */
.li-results { max-width:900px; margin:0 auto; padding:2rem 1.25rem 5rem; }

/* Score header */
.li-score-block {
    display:flex; gap:2rem; align-items:center;
    background:#fff; border-radius:24px; padding:2rem;
    border:1.5px solid rgba(0,0,0,.07);
    box-shadow:0 8px 40px rgba(0,0,0,.07);
    margin-bottom:1.5rem; flex-wrap:wrap;
}
html.dark .li-score-block { background:#161619; border-color:rgba(255,255,255,.08); }

.li-gauge-wrap { flex-shrink:0; }
.li-gauge {
    width:130px; height:130px; border-radius:50%;
    display:flex; align-items:center; justify-content:center; position:relative;
}
.li-gauge__hole {
    position:absolute; inset:14px; border-radius:50%; background:#fff;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
}
html.dark .li-gauge__hole { background:#161619; }
.li-gauge__score { font-family:'Space Grotesk',sans-serif; font-size:2.2rem; font-weight:900; line-height:1; }
.li-gauge__sub { font-size:.65rem; color:#9ca3af; font-weight:600; }

.li-score-meta { flex:1; min-width:200px; }
.li-niveau-badge {
    display:inline-block; padding:.28rem .85rem; border-radius:50px;
    font-size:.73rem; font-weight:800; letter-spacing:.02em; margin-bottom:.75rem;
}
.niveau--debut    { background:rgba(239,68,68,.08); color:#dc2626; }
.niveau--progres  { background:rgba(245,158,11,.08); color:#d97706; }
.niveau--bon      { background:rgba(34,197,94,.08); color:#16a34a; }
.niveau--excellent{ background:rgba(10,102,194,.08); color:#0a66c2; }

.li-score-meta h2 { font-family:'Space Grotesk',sans-serif; font-size:1.25rem; font-weight:800; color:#111; margin-bottom:.4rem; }
html.dark .li-score-meta h2 { color:#f3f4f6; }
.li-score-meta p { font-size:.875rem; line-height:1.65; color:#6b7280; }
html.dark .li-score-meta p { color:#9ca3af; }

/* Profile meta (scraped) */
.li-profile-meta {
    display:flex; align-items:center; gap:.85rem; padding:1rem;
    background:rgba(10,102,194,.04); border-radius:12px; margin-top:.75rem;
    border:1px solid rgba(10,102,194,.1);
}
html.dark .li-profile-meta { background:rgba(10,102,194,.08); border-color:rgba(96,165,250,.15); }
.li-profile-meta__av {
    width:44px; height:44px; border-radius:50%; flex-shrink:0; object-fit:cover;
    background:linear-gradient(135deg,var(--li),#0284c7);
    display:flex; align-items:center; justify-content:center;
    color:white; font-weight:800; font-size:.95rem; overflow:hidden;
}
.li-profile-meta__name { font-weight:700; font-size:.88rem; color:#111; }
html.dark .li-profile-meta__name { color:#f3f4f6; }
.li-profile-meta__loc { font-size:.75rem; color:#6b7280; }

/* ── POSITIONNEMENT (star feature) ── */
.li-positioning {
    background:linear-gradient(135deg,#0a1628 0%,#0f2040 60%,#0a2a1a 100%);
    border-radius:24px; padding:2rem; margin-bottom:1.5rem;
    position:relative; overflow:hidden;
}
.li-positioning::before {
    content:''; position:absolute; inset:0;
    background-image:radial-gradient(rgba(10,102,194,.15) 1px,transparent 1px);
    background-size:30px 30px; pointer-events:none;
}
.li-pos-header {
    display:flex; align-items:center; gap:.75rem; margin-bottom:1.5rem; position:relative;
}
.li-pos-icon {
    width:40px; height:40px; border-radius:10px;
    background:linear-gradient(135deg,var(--li),#0284c7);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.li-pos-title { font-family:'Space Grotesk',sans-serif; font-size:1.1rem; font-weight:800; color:#fff; }
.li-pos-sub { font-size:.78rem; color:rgba(255,255,255,.6); }

.li-pos-cards { display:flex; flex-direction:column; gap:.85rem; position:relative; }
.li-pos-card {
    background:rgba(255,255,255,.06); backdrop-filter:blur(8px);
    border:1px solid rgba(255,255,255,.1); border-radius:16px;
    padding:1.1rem 1.25rem; position:relative; overflow:hidden;
}
.li-pos-card__num {
    position:absolute; top:.75rem; right:.85rem;
    font-size:.65rem; font-weight:800; color:rgba(255,255,255,.3); letter-spacing:.08em;
}
.li-pos-card__text {
    font-size:.88rem; line-height:1.65; color:rgba(255,255,255,.9);
    padding-right:2rem;
}
.li-pos-card__actions {
    display:flex; gap:.5rem; margin-top:.85rem;
}
.li-pos-copy {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.35rem .85rem; border-radius:8px; border:none; cursor:pointer;
    background:rgba(10,102,194,.3); color:rgba(255,255,255,.9);
    font-size:.73rem; font-weight:600; transition:all .2s;
}
.li-pos-copy:hover { background:rgba(10,102,194,.5); }
.li-pos-copy.copied { background:rgba(34,197,94,.3); color:#86efac; }
.li-pos-linkedin {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.35rem .85rem; border-radius:8px;
    background:var(--li); color:#fff;
    font-size:.73rem; font-weight:700; text-decoration:none; transition:all .2s;
}
.li-pos-linkedin:hover { background:#0952a5; }

/* ── GRILLE résultats ── */
.li-results-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.25rem; }
@media(max-width:700px){ .li-results-grid{ grid-template-columns:1fr; } }

.li-card {
    background:#fff; border-radius:20px; padding:1.5rem;
    border:1.5px solid rgba(0,0,0,.07);
    box-shadow:0 2px 16px rgba(0,0,0,.05);
}
html.dark .li-card { background:#161619; border-color:rgba(255,255,255,.08); }

.li-card__eyebrow { font-size:.68rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:#9ca3af; margin-bottom:1.1rem; }

/* Catégories */
.li-cat { margin-bottom:.9rem; }
.li-cat:last-child { margin-bottom:0; }
.li-cat__top { display:flex; justify-content:space-between; align-items:center; margin-bottom:.3rem; }
.li-cat__name { font-size:.82rem; font-weight:600; color:#374151; }
html.dark .li-cat__name { color:#d1d5db; }
.li-cat__score { font-size:.82rem; font-weight:800; color:#111; }
html.dark .li-cat__score { color:#f3f4f6; }
.li-cat__track { height:7px; border-radius:3.5px; background:rgba(0,0,0,.06); overflow:hidden; }
html.dark .li-cat__track { background:rgba(255,255,255,.06); }
.li-cat__fill { height:100%; border-radius:3.5px; animation:catFill .8s var(--ease) both; }
@keyframes catFill { from{width:0} }
.li-cat__fill--hi  { background:linear-gradient(90deg,#16a34a,#22c55e); }
.li-cat__fill--mid { background:linear-gradient(90deg,#d97706,#f59e0b); }
.li-cat__fill--lo  { background:linear-gradient(90deg,#dc2626,#ef4444); }
.li-cat__comment { font-size:.73rem; color:#9ca3af; margin-top:.3rem; line-height:1.4; }

/* Forces */
.li-force { display:flex; gap:.55rem; margin-bottom:.65rem; align-items:flex-start; }
.li-force:last-child { margin-bottom:0; }
.li-force__icon {
    flex-shrink:0; width:20px; height:20px; border-radius:6px; margin-top:1px;
    background:rgba(34,197,94,.1); display:flex; align-items:center; justify-content:center;
}
.li-force__icon svg { color:#16a34a; }
.li-force__text { font-size:.84rem; line-height:1.55; color:#374151; }
html.dark .li-force__text { color:#d1d5db; }

/* Actions immédiates */
.li-actions {
    background:linear-gradient(135deg,var(--fr),#a03030);
    border-radius:20px; padding:1.5rem; margin-bottom:1.25rem;
    color:#fff;
}
.li-actions__title { font-family:'Space Grotesk',sans-serif; font-weight:800; font-size:1rem; margin-bottom:1rem; }
.li-action-item { display:flex; gap:.6rem; align-items:flex-start; margin-bottom:.7rem; }
.li-action-item:last-child { margin-bottom:0; }
.li-action-item__n {
    flex-shrink:0; width:22px; height:22px; border-radius:50%;
    background:rgba(255,255,255,.2); font-size:.7rem; font-weight:800;
    display:flex; align-items:center; justify-content:center;
}
.li-action-item__t { font-size:.855rem; line-height:1.55; opacity:.92; }

/* Recommandations */
.li-recos { background:#fff; border-radius:20px; padding:1.5rem; margin-bottom:1.25rem; border:1.5px solid rgba(0,0,0,.07); box-shadow:0 2px 16px rgba(0,0,0,.05); }
html.dark .li-recos { background:#161619; border-color:rgba(255,255,255,.08); }
.li-reco { display:flex; gap:.75rem; padding:.85rem 0; border-bottom:1px solid rgba(0,0,0,.05); align-items:flex-start; }
html.dark .li-reco { border-color:rgba(255,255,255,.04); }
.li-reco:last-child { border-bottom:none; padding-bottom:0; }
.li-reco:first-child { padding-top:0; }
.li-reco__pri {
    flex-shrink:0; padding:.2rem .55rem; border-radius:50px;
    font-size:.68rem; font-weight:800; letter-spacing:.02em; text-transform:uppercase; white-space:nowrap;
}
.li-reco__pri--haute   { background:rgba(220,38,38,.08); color:#dc2626; }
.li-reco__pri--moyenne { background:rgba(245,158,11,.08); color:#d97706; }
.li-reco__pri--basse   { background:rgba(34,197,94,.08); color:#16a34a; }
.li-reco__action { font-size:.875rem; font-weight:600; color:#111; margin-bottom:.2rem; line-height:1.4; }
html.dark .li-reco__action { color:#f3f4f6; }
.li-reco__impact { font-size:.78rem; color:#9ca3af; }

/* Bottom CTAs */
.li-bottom-ctas { display:flex; gap:.75rem; flex-wrap:wrap; justify-content:center; margin-top:1.5rem; }
.li-cta-ghost {
    padding:.7rem 1.6rem; border-radius:12px;
    border:1.5px solid rgba(10,102,194,.25); background:transparent;
    color:var(--li); font-weight:700; font-size:.875rem; cursor:pointer; transition:all .2s;
    text-decoration:none;
}
html.dark .li-cta-ghost { border-color:rgba(96,165,250,.25); color:#60a5fa; }
.li-cta-ghost:hover { background:rgba(10,102,194,.06); }
.li-cta-primary {
    padding:.7rem 1.6rem; border-radius:12px;
    background:linear-gradient(135deg,var(--fr),#c04040); color:#fff;
    font-weight:700; font-size:.875rem; text-decoration:none;
    display:inline-flex; align-items:center; gap:.4rem;
    box-shadow:0 4px 16px rgba(135,35,35,.3); transition:all .2s;
}
.li-cta-primary:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(135,35,35,.4); }
</style>
@endpush

@section('content')
<div class="li-page">

{{-- ══ HERO ══ --}}
<section class="li-hero">
    <div class="li-hero__mesh" aria-hidden="true"></div>
    <div class="li-hero__inner">

        <div class="li-hero__text" data-reveal>
            <div class="li-hero__badge">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                Analyse IA · Score /100 · Phrases générées
            </div>
            <h1 class="li-hero__h1">
                Score ton profil <span class="li-accent">LinkedIn</span><br>
                et obtiens tes<br>
                <span class="li-accent-2">phrases de positionnement</span>
            </h1>
            <p class="li-hero__sub">Colle ton URL LinkedIn ou le contenu de ton profil — l'IA analyse, donne un score détaillé et génère 3 phrases percutantes prêtes à copier-coller sur LinkedIn.</p>
            <div class="li-trust">
                <div class="li-trust__item"><span class="li-trust__dot li-trust__dot--blue"></span>Scraping automatique</div>
                <div class="li-trust__item"><span class="li-trust__dot li-trust__dot--green"></span>Phrases de positionnement incluses</div>
                <div class="li-trust__item"><span class="li-trust__dot li-trust__dot--gold"></span>Adapté Afrique → Monde</div>
            </div>
        </div>

        {{-- Visuel hero --}}
        <div class="li-hero__mockup" data-reveal data-reveal-delay="1">
            <img src="{{ asset('assets/3.webp') }}"
                 alt="Analyse profil LinkedIn avec IA"
                 width="440" height="360"
                 style="width:100%;height:auto;border-radius:24px;box-shadow:0 32px 80px rgba(10,102,194,.2),0 4px 16px rgba(0,0,0,.08);display:block;margin-bottom:1.5rem;">

            <div class="li-mockup-card">
                <div class="li-mock-banner"></div>
                <div class="li-mock-profile">
                    <div class="li-mock-av">A</div>
                    <div>
                        <div class="li-mock-name">Aminata D.</div>
                        <div class="li-mock-title">Laravel Dev · Dakar · Remote</div>
                    </div>
                </div>
                <div class="li-mock-score-row">
                    <div style="flex:1">
                        <div class="li-mock-bar">
                            <div class="li-mock-bar__top"><span>Titre</span><span>16/20</span></div>
                            <div class="li-mock-bar__track"><div class="li-mock-bar__fill li-mock-bar__fill--1"></div></div>
                        </div>
                        <div class="li-mock-bar">
                            <div class="li-mock-bar__top"><span>À propos</span><span>13/20</span></div>
                            <div class="li-mock-bar__track"><div class="li-mock-bar__fill li-mock-bar__fill--2"></div></div>
                        </div>
                        <div class="li-mock-bar">
                            <div class="li-mock-bar__top"><span>Visibilité</span><span>11/20</span></div>
                            <div class="li-mock-bar__track"><div class="li-mock-bar__fill li-mock-bar__fill--3"></div></div>
                        </div>
                        <div class="li-mock-bar">
                            <div class="li-mock-bar__top"><span>Expériences</span><span>18/20</span></div>
                            <div class="li-mock-bar__track"><div class="li-mock-bar__fill li-mock-bar__fill--4"></div></div>
                        </div>
                    </div>
                    <div class="li-mock-score" style="margin-left:1rem">
                        <div class="li-mock-score__inner">
                            <div class="li-mock-score__n">74</div>
                            <div class="li-mock-score__l">/100</div>
                        </div>
                    </div>
                </div>
                <div class="li-mock-phrase">"Développeuse Laravel Senior · 6 ans · Remote depuis Dakar · Je livre des SaaS performants pour startups européennes"</div>
            </div>
            <div class="li-float-badge li-float-badge--1">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                +42% de vues profil
            </div>
            <div class="li-float-badge li-float-badge--2">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                3 phrases générées
            </div>
        </div>
    </div>
</section>

{{-- ══ FORM ou RÉSULTATS ══ --}}

@if($result)

{{-- ════════ RÉSULTATS ════════ --}}
<div class="li-results">

    @php
        $score = $result['score_global'] ?? 0;
        $meta  = $result['profile_meta'] ?? null;
        $deg   = ($score / 100) * 360;
        [$gaugeColor, $niveauClass, $niveauLabel] = match(true) {
            $score < 40  => ['#dc2626','niveau--debut','Débutant'],
            $score < 60  => ['#d97706','niveau--progres','En progression'],
            $score < 80  => ['#16a34a','niveau--bon','Bon profil'],
            default      => ['#0a66c2','niveau--excellent','Excellent profil'],
        };
    @endphp

    {{-- Score header --}}
    <div class="li-score-block">
        <div class="li-gauge-wrap">
            <div class="li-gauge" id="li-gauge-el"
                 style="background:conic-gradient({{ $gaugeColor }} 0deg, rgba(0,0,0,.07) 0deg)">
                <div class="li-gauge__hole">
                    <span class="li-gauge__score" style="color:{{ $gaugeColor }}">{{ $score }}</span>
                    <span class="li-gauge__sub">/ 100</span>
                </div>
            </div>
        </div>
        <div class="li-score-meta">
            <span class="li-niveau-badge {{ $niveauClass }}">{{ $niveauLabel }}</span>
            @if($meta)
                <div class="li-profile-meta">
                    <div class="li-profile-meta__av">
                        @if(!empty($meta['avatar']))
                            <img src="{{ $meta['avatar'] }}" alt="Photo de profil" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{ strtoupper(substr($meta['name'] ?? 'P', 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="li-profile-meta__name">{{ $meta['name'] ?? 'Profil LinkedIn' }}</div>
                        @if(!empty($meta['headline']))<div class="li-profile-meta__loc">{{ $meta['headline'] }}</div>@endif
                        @if(!empty($meta['location']))<div class="li-profile-meta__loc" style="display:flex;align-items:center;gap:.3rem"><svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> {{ $meta['location'] }}</div>@endif
                    </div>
                </div>
            @else
                <h2>Analyse de ton profil LinkedIn</h2>
            @endif
            <p style="margin-top:.5rem">{{ $result['resume_global'] ?? '' }}</p>
        </div>
    </div>

    {{-- ★ POSITIONNEMENT (feature principale) ★ --}}
    @if(!empty($result['positionnement']))
    <div class="li-positioning">
        <div class="li-pos-header">
            <div class="li-pos-icon">
                <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
            <div>
                <div class="li-pos-title">Tes phrases de positionnement LinkedIn</div>
                <div class="li-pos-sub">Générées à partir de ton profil réel · Copie-les maintenant</div>
            </div>
        </div>
        <div class="li-pos-cards">
            @foreach(['p1'=>'Headline direct','p2'=>'Version narrative','p3'=>'Orientée résultats'] as $key => $label)
                @if(!empty($result['positionnement'][$key]))
                <div class="li-pos-card">
                    <div class="li-pos-card__num">{{ $label }}</div>
                    <div class="li-pos-card__text" id="pos-{{ $key }}">{{ $result['positionnement'][$key] }}</div>
                    <div class="li-pos-card__actions">
                        <button class="li-pos-copy" onclick="copyPos('{{ $key }}', this)">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                            Copier
                        </button>
                        <a href="https://www.linkedin.com/profile/edit" target="_blank" rel="noopener" class="li-pos-linkedin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="white"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            Mettre sur LinkedIn
                        </a>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- Grille : catégories + forces --}}
    <div class="li-results-grid">
        <div class="li-card">
            <div class="li-card__eyebrow">Scores par catégorie</div>
            @php
                $cats = $result['categories'] ?? [];
                $catLabels = ['titre'=>'Titre / Headline','resume'=>'À propos','competences'=>'Compétences','experiences'=>'Expériences','visibilite'=>'Visibilité & Réseau'];
            @endphp
            @foreach($catLabels as $k => $lbl)
                @if(isset($cats[$k]))
                    @php $sc=$cats[$k]['score']??0; $pct=($sc/20)*100; $cl=$pct>=70?'hi':($pct>=40?'mid':'lo'); @endphp
                    <div class="li-cat">
                        <div class="li-cat__top">
                            <span class="li-cat__name">{{ $lbl }}</span>
                            <span class="li-cat__score">{{ $sc }}/20</span>
                        </div>
                        <div class="li-cat__track">
                            <div class="li-cat__fill li-cat__fill--{{ $cl }}" style="width:{{ $pct }}%;animation-delay:{{ $loop->index*0.1 }}s"></div>
                        </div>
                        <div class="li-cat__comment">{{ $cats[$k]['commentaire']??'' }}</div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="li-card">
            <div class="li-card__eyebrow">Tes points forts</div>
            @foreach($result['forces'] ?? [] as $f)
                <div class="li-force">
                    <div class="li-force__icon"><svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <div class="li-force__text">{{ $f }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Actions immédiates --}}
    @if(!empty($result['actions_immediates']))
    <div class="li-actions">
        <div class="li-actions__title" style="display:flex;align-items:center;gap:.5rem">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            3 choses à faire maintenant
        </div>
        @foreach($result['actions_immediates'] as $i => $a)
            <div class="li-action-item">
                <div class="li-action-item__n">{{ $i+1 }}</div>
                <div class="li-action-item__t">{{ $a }}</div>
            </div>
        @endforeach
    </div>
    @endif

    {{-- Recommandations --}}
    <div class="li-recos">
        <div class="li-card__eyebrow" style="margin-bottom:0">Recommandations détaillées</div>
        @foreach($result['recommandations'] ?? [] as $r)
            <div class="li-reco">
                <span class="li-reco__pri li-reco__pri--{{ $r['priorite']??'moyenne' }}">{{ ucfirst($r['priorite']??'') }}</span>
                <div>
                    <div class="li-reco__action">{{ $r['action']??'' }}</div>
                    @if(!empty($r['impact']))<div class="li-reco__impact">→ {{ $r['impact'] }}</div>@endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- CTAs --}}
    <div class="li-bottom-ctas">
        <a href="{{ route('linkedin.analyse') }}" class="li-cta-ghost">Analyser un autre profil</a>
        <a href="{{ route('positionnement') }}" class="li-cta-primary">
            Approfondir mon positionnement
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>
</div>

@else

{{-- ════════ FORMULAIRE ════════ --}}
<div class="li-form-section" x-data="{ mode: 'url' }">

    {{-- Tabs --}}
    <div class="li-tabs">
        <button type="button" class="li-tab" :class="{ active: mode==='url' }" @click="mode='url'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
            URL LinkedIn (automatique)
        </button>
        <button type="button" class="li-tab" :class="{ active: mode==='paste' }" @click="mode='paste'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Coller le profil
        </button>
    </div>

    <div class="li-form-card">

        @if($errors->any())
            <div class="li-error-box">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form id="liForm" method="POST" action="{{ route('linkedin.analyser') }}" onsubmit="startAnalyse()">
            @csrf
            <input type="hidden" name="input_mode" :value="mode" x-bind:value="mode">

            {{-- Mode URL --}}
            <div x-show="mode==='url'">
                <p style="font-size:.875rem;color:#6b7280;margin-bottom:1rem;">
                    Colle l'URL de ton profil LinkedIn et on s'occupe du reste. <strong>Nécessite RAPIDAPI_KEY.</strong>
                </p>
                <div class="li-url-wrap">
                    <div class="li-url-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="#0a66c2"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </div>
                    <input type="text" name="profil_url" class="li-url-input"
                           placeholder="linkedin.com/in/ton-pseudo ou https://www.linkedin.com/in/ton-pseudo/"
                           value="{{ old('profil_url') }}">
                </div>
                <div class="li-url-hint">Ex : linkedin.com/in/aminata-diallo — public ou visible</div>
            </div>

            {{-- Mode Paste --}}
            <div x-show="mode==='paste'" style="display:none">
                <p style="font-size:.875rem;color:#6b7280;margin-bottom:.75rem;">
                    Copie le contenu de ton profil et colle-le ici. Plus tu mets, meilleure sera l'analyse.
                </p>
                <div class="li-chips">
                    <span class="li-chip">Titre LinkedIn</span>
                    <span class="li-chip">Section À propos</span>
                    <span class="li-chip">Compétences</span>
                    <span class="li-chip">Expériences</span>
                    <span class="li-chip">Formation</span>
                </div>
                <textarea name="profil_texte" class="li-textarea"
                    placeholder="Exemple :&#10;&#10;Titre : Développeur Laravel Senior | Remote | Freelance&#10;&#10;À propos : Je construis des applications web performantes depuis 6 ans...&#10;&#10;Compétences : Laravel, PHP, React, Docker, MySQL...&#10;&#10;Expériences : Lead Dev chez Startup X (2022–2024)...">{{ old('profil_texte') }}</textarea>
            </div>

            <button type="submit" class="li-submit" id="liBtn">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Analyser mon profil avec l'IA
            </button>
        </form>

        <div class="li-loading" id="liLoading">
            <div class="li-spinner"></div>
            <div class="li-loading__steps">
                <div class="li-loading__step active" id="step1"><span class="li-step-dot"></span>Récupération du profil…</div>
                <div class="li-loading__step" id="step2"><span class="li-step-dot"></span>Analyse IA en cours…</div>
                <div class="li-loading__step" id="step3"><span class="li-step-dot"></span>Génération des phrases de positionnement…</div>
                <div class="li-loading__step" id="step4"><span class="li-step-dot"></span>Finalisation du rapport…</div>
            </div>
        </div>
    </div>
</div>

@endif
</div>
@endsection

@push('scripts')
<script>
function startAnalyse() {
    document.getElementById('liForm').style.display = 'none';
    document.getElementById('liLoading').classList.add('show');
    document.getElementById('liBtn').disabled = true;
    // Animate loading steps
    const steps = ['step1','step2','step3','step4'];
    let i = 0;
    const interval = setInterval(() => {
        if (i > 0) {
            steps[i-1] && document.getElementById(steps[i-1])?.classList.replace('active','done');
        }
        if (i < steps.length) {
            document.getElementById(steps[i])?.classList.add('active');
            i++;
        } else {
            clearInterval(interval);
        }
    }, 4000);
}

function copyPos(key, btn) {
    const text = document.getElementById('pos-' + key)?.textContent?.trim();
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        btn.textContent = '✓ Copié !';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.innerHTML = '<svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg> Copier';
            btn.classList.remove('copied');
        }, 2500);
    });
}

// Animate gauge on result page
@if($result)
(function() {
    const el = document.getElementById('li-gauge-el');
    if (!el) return;
    const target = {{ ($result['score_global'] ?? 0) / 100 * 360 }};
    const color  = '{{ $gaugeColor ?? "#0a66c2" }}';
    let cur = 0;
    const step = target / 45;
    const t = setInterval(() => {
        cur = Math.min(cur + step, target);
        el.style.background = `conic-gradient(${color} ${cur}deg, rgba(0,0,0,.07) 0deg)`;
        if (cur >= target) clearInterval(t);
    }, 16);
})();
@endif
</script>
@endpush
