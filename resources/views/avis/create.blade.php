@extends('layouts.app')
@section('title', 'Laisser un avis - Fidow')

@section('content')
<div class="fac-page">

    <div class="fac-bg" aria-hidden="true">
        <div class="fac-blob fac-blob--1"></div>
        <div class="fac-blob fac-blob--2"></div>
        <div class="fac-ring"></div>
    </div>

    <div class="fac-container">

        {{-- HEADER --}}
        <header class="fac-header" data-reveal>
            <nav class="fac-breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('avis.index') }}">Témoignages</a>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                <span>Laisser un avis</span>
            </nav>

            <div class="fac-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5"/><path d="M17.5 2.5a2.12 2.12 0 0 1 3 3L12 14l-4 1 1-4Z"/></svg>
                Partager votre expérience
            </div>

            <h1 class="fac-header__title">
                Votre avis sur <span>Fidow</span>
            </h1>
            <p class="fac-header__sub">
                Votre retour aide la communauté remote à découvrir les outils qui font la différence.
            </p>
        </header>

        {{-- FORM CARD --}}
        <div class="fac-card" data-reveal data-reveal-delay="1">

            {{-- Success flash --}}
            @if(session('success'))
            <div class="fac-flash fac-flash--success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- Info modération --}}
            <div class="fac-info">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Votre avis sera <strong>modéré avant publication</strong>. Traitement sous 24h.</span>
            </div>

            <form action="{{ route('avis.store') }}" method="POST" class="fac-form" id="avisForm">
                @csrf

                {{-- STEP INDICATOR --}}
                <div class="fac-steps">
                    <div class="fac-step fac-step--active" id="step-1">
                        <div class="fac-step__dot"><span>1</span></div>
                        <div class="fac-step__lbl">Identité</div>
                    </div>
                    <div class="fac-step__line"></div>
                    <div class="fac-step" id="step-2">
                        <div class="fac-step__dot"><span>2</span></div>
                        <div class="fac-step__lbl">Évaluation</div>
                    </div>
                    <div class="fac-step__line"></div>
                    <div class="fac-step" id="step-3">
                        <div class="fac-step__dot"><span>3</span></div>
                        <div class="fac-step__lbl">Commentaire</div>
                    </div>
                </div>

                {{-- Grille 2 colonnes : Nom + Email --}}
                <div class="fac-row-2">
                    <div class="fac-field">
                        <label for="nom">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7"/></svg>
                            Votre nom <span>*</span>
                        </label>
                        <input type="text" id="nom" name="nom" required
                               value="{{ old('nom') }}"
                               placeholder="Jean Dupont"
                               class="fac-input {{ $errors->has('nom') ? 'fac-input--err' : '' }}">
                        @error('nom')<p class="fac-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="fac-field">
                        <label for="email">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Votre email <span>*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                               value="{{ old('email') }}"
                               placeholder="jean@exemple.com"
                               class="fac-input {{ $errors->has('email') ? 'fac-input--err' : '' }}">
                        @error('email')<p class="fac-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- NOTE INTERACTIVE --}}
                <div class="fac-field">
                    <label>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        Votre note <span>*</span>
                    </label>
                    <div class="fac-star-picker" id="starPicker">
                        <input type="hidden" name="note" id="noteInput" value="{{ old('note', 5) }}">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="fac-star {{ old('note', 5) >= $i ? 'fac-star--on' : '' }}"
                                data-val="{{ $i }}" aria-label="{{ $i }} étoile{{ $i > 1 ? 's' : '' }}">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </button>
                        @endfor
                        <span class="fac-star-label" id="starLabel">Excellent</span>
                    </div>
                    @error('note')<p class="fac-error">{{ $message }}</p>@enderror
                </div>

                {{-- COMMENTAIRE --}}
                <div class="fac-field">
                    <label for="commentaire">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Votre commentaire <span>*</span>
                    </label>
                    <div class="fac-textarea-wrap">
                        <textarea id="commentaire" name="commentaire" required rows="5"
                                  placeholder="Partagez votre expérience avec Fidow — outil utilisé, résultats obtenus, ce que vous recommanderiez..."
                                  class="fac-textarea {{ $errors->has('commentaire') ? 'fac-input--err' : '' }}"
                                  maxlength="2000">{{ old('commentaire') }}</textarea>
                        <div class="fac-char-count">
                            <span id="charCount">0</span>/2000 caractères
                        </div>
                    </div>
                    <p class="fac-hint">Minimum 10 caractères — votre témoignage aide d'autres professionnels.</p>
                    @error('commentaire')<p class="fac-error">{{ $message }}</p>@enderror
                </div>

                {{-- SUBMIT ROW --}}
                <div class="fac-submit-row">
                    <a href="{{ route('avis.index') }}" class="fac-back-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                        Retour aux avis
                    </a>
                    <button type="submit" class="fac-submit" id="submitBtn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Envoyer mon avis
                    </button>
                </div>

            </form>
        </div>

        {{-- Témoignage déjà publié en preview --}}
        <div class="fac-preview-section" data-reveal>
            <div class="fac-preview-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Aperçu de votre avis tel qu'il apparaîtra
            </div>
            <div class="fac-preview-card">
                <div class="fac-preview__stars" id="previewStars"></div>
                <p class="fac-preview__text" id="previewText">Votre commentaire apparaîtra ici...</p>
                <div class="fac-preview__footer">
                    <div class="fac-preview__av" id="previewAv">?</div>
                    <div>
                        <strong id="previewNom">Votre nom</strong>
                        <span>Aujourd'hui</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="fav-footer-nav" style="margin-top:2.5rem;" data-reveal>
            <a href="{{ route('home') }}" class="fav-nav-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Accueil
            </a>
            <a href="{{ route('positionnement') }}" class="fav-nav-link fav-nav-link--primary">
                Essayer un outil
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
:root{--f-red:#872323;--f-ease:cubic-bezier(.16,1,.3,1);}

/* ── DARK MODE OVERRIDES ── */
html.dark .fac-page{background:#0c0c0f;}
html.dark .fac-header__title{color:#f3f4f6;}
html.dark .fac-header__sub{color:#9ca3af;}
html.dark .fac-breadcrumb a{color:#9ca3af;}
html.dark .fac-card{background:#161619;border-color:rgba(255,255,255,.07);box-shadow:0 16px 56px rgba(0,0,0,.4);}
html.dark .fac-info{background:rgba(135,35,35,.06);border-color:rgba(135,35,35,.15);color:#9ca3af;}
html.dark .fac-info strong{color:#d1d5db;}
html.dark .fac-step__dot{border-color:rgba(255,255,255,.1);color:#6b7280;}
html.dark .fac-step--active .fac-step__dot{border-color:var(--f-red);background:var(--f-red);color:#fff;}
html.dark .fac-step--done .fac-step__dot{border-color:#059669;background:#059669;color:#fff;}
html.dark .fac-step__lbl{color:#6b7280;}
html.dark .fac-step--active .fac-step__lbl{color:var(--f-red);}
html.dark .fac-step--done .fac-step__lbl{color:#059669;}
html.dark .fac-step__line{background:rgba(255,255,255,.08);}
html.dark .fac-field label{color:#d1d5db;}
html.dark .fac-field label span{color:var(--f-red);}
html.dark .fac-input,.fac-textarea{background:#111114;border-color:rgba(255,255,255,.1);color:#f3f4f6;}
html.dark .fac-input:focus,.fac-textarea:focus{border-color:var(--f-red);background:#161619;box-shadow:0 0 0 4px rgba(135,35,35,.12);}
html.dark .fac-input--err{border-color:#dc2626 !important;}
html.dark .fac-star-picker{background:#111114;border-color:rgba(255,255,255,.1);}
html.dark .fac-hint{color:#6b7280;}
html.dark .fac-char-count{color:#6b7280;}
html.dark .fac-back-link{color:#6b7280;}
html.dark .fac-back-link:hover{color:var(--f-red);}
html.dark .fac-preview-card{background:#161619;border-color:rgba(135,35,35,.15);}
html.dark .fac-preview__text{color:#d1d5db;}
html.dark .fac-preview__footer{border-color:rgba(255,255,255,.06);}
html.dark .fac-preview__footer strong{color:#f3f4f6;}
html.dark .fac-preview__footer span{color:#6b7280;}
html.dark .fac-preview-label{color:#6b7280;}
html.dark .fav-nav-link{background:#161619;border-color:rgba(255,255,255,.07);color:#9ca3af;}
html.dark .fav-nav-link:hover{border-color:rgba(135,35,35,.3);color:var(--f-red);}
[data-reveal]{opacity:0;transform:translateY(26px);transition:opacity .65s var(--f-ease),transform .65s var(--f-ease);}
[data-reveal].is-visible{opacity:1;transform:translateY(0);}
[data-reveal-delay="1"]{transition-delay:.12s;}

.fac-page{min-height:100vh;background:#fafafa;position:relative;overflow:hidden;padding-bottom:4rem;}
.fac-bg{position:fixed;inset:0;pointer-events:none;z-index:0;}
.fac-blob{position:absolute;border-radius:50%;filter:blur(80px);}
.fac-blob--1{width:500px;height:300px;background:radial-gradient(ellipse,rgba(135,35,35,.08) 0%,transparent 70%);top:-60px;right:-100px;}
.fac-blob--2{width:350px;height:350px;background:radial-gradient(circle,rgba(135,35,35,.05) 0%,transparent 70%);bottom:10%;left:-80px;}
.fac-ring{position:absolute;width:700px;height:700px;border-radius:50%;border:1px solid rgba(135,35,35,.05);top:30%;left:50%;transform:translate(-50%,-50%);animation:facRing 12s ease-in-out infinite;}
@keyframes facRing{0%,100%{transform:translate(-50%,-50%) scale(1)}50%{transform:translate(-50%,-50%) scale(1.04)}}

.fac-container{position:relative;z-index:2;max-width:760px;margin:0 auto;padding:0 1.5rem;}

.fac-header{text-align:center;padding:4rem 0 1.5rem;}
.fac-breadcrumb{display:inline-flex;align-items:center;gap:.4rem;font-size:.85rem;color:#9ca3af;margin-bottom:1rem;}
.fac-breadcrumb a{color:#6b7280;text-decoration:none;transition:color .2s;}
.fac-breadcrumb a:hover{color:var(--f-red);}
.fac-breadcrumb span{color:var(--f-red);font-weight:700;}
.fac-badge{display:inline-flex;align-items:center;gap:.5rem;padding:.42rem .9rem;border-radius:999px;background:rgba(135,35,35,.07);border:1px solid rgba(135,35,35,.14);color:var(--f-red);font-size:.78rem;font-weight:700;margin-bottom:1rem;}
.fac-header__title{font-family:'Space Grotesk',sans-serif;font-size:clamp(2rem,4vw,3.2rem);font-weight:800;letter-spacing:-.05em;color:#111;margin:0 0 .75rem;}
.fac-header__title span{background:linear-gradient(135deg,var(--f-red),#c04040);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.fac-header__sub{color:#6b7280;font-size:1rem;line-height:1.75;max-width:52ch;margin:0 auto;}

/* ── CARD ── */
.fac-card{background:#fff;border:1px solid rgba(17,17,17,.07);border-radius:28px;padding:2.25rem;box-shadow:0 16px 56px rgba(0,0,0,.07);margin-bottom:1.25rem;}

.fac-flash{display:flex;align-items:center;gap:.6rem;padding:1rem 1.25rem;border-radius:14px;margin-bottom:1.5rem;font-size:.9rem;font-weight:600;}
.fac-flash--success{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);color:#059669;}
.fac-info{display:flex;align-items:center;gap:.6rem;padding:.85rem 1.1rem;background:rgba(135,35,35,.04);border:1px solid rgba(135,35,35,.1);border-radius:12px;font-size:.82rem;color:#6b7280;margin-bottom:1.75rem;}
.fac-info strong{color:#374151;}

/* ── STEPS ── */
.fac-steps{display:flex;align-items:center;margin-bottom:2rem;}
.fac-step{display:flex;align-items:center;gap:.5rem;flex-shrink:0;}
.fac-step__dot{width:30px;height:30px;border-radius:50%;border:2px solid #e5e7eb;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:800;color:#9ca3af;transition:.3s var(--f-ease);}
.fac-step--active .fac-step__dot{border-color:var(--f-red);background:var(--f-red);color:#fff;}
.fac-step--done .fac-step__dot{border-color:#059669;background:#059669;color:#fff;}
.fac-step__lbl{font-size:.78rem;font-weight:700;color:#9ca3af;}
.fac-step--active .fac-step__lbl{color:var(--f-red);}
.fac-step--done .fac-step__lbl{color:#059669;}
.fac-step__line{flex:1;height:2px;background:#e5e7eb;margin:0 .5rem;}

/* ── FORM ── */
.fac-form{display:flex;flex-direction:column;gap:1.4rem;}
.fac-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.fac-field{display:flex;flex-direction:column;gap:.5rem;}
.fac-field label{display:flex;align-items:center;gap:.4rem;font-size:.84rem;font-weight:800;color:#374151;}
.fac-field label span{color:var(--f-red);}
.fac-input,.fac-textarea{width:100%;padding:.85rem 1rem;border:1.5px solid #e5e7eb;border-radius:14px;font-size:.92rem;color:#111;background:#fafafa;transition:border-color .2s,box-shadow .2s,background .2s;outline:none;resize:none;}
.fac-input:focus,.fac-textarea:focus{border-color:var(--f-red);background:#fff;box-shadow:0 0 0 4px rgba(135,35,35,.08);}
.fac-input--err{border-color:#dc2626 !important;}
.fac-error{font-size:.8rem;color:#dc2626;font-weight:600;}
.fac-hint{font-size:.78rem;color:#9ca3af;}
.fac-textarea-wrap{position:relative;}
.fac-char-count{position:absolute;bottom:.7rem;right:.9rem;font-size:.74rem;color:#9ca3af;pointer-events:none;}

/* ── STAR PICKER ── */
.fac-star-picker{display:flex;align-items:center;gap:.3rem;padding:.75rem 1rem;background:#fafafa;border:1.5px solid #e5e7eb;border-radius:14px;}
.fac-star{background:none;border:none;cursor:pointer;padding:.1rem;color:#d1d5db;transition:color .15s,transform .15s;}
.fac-star svg{width:32px;height:32px;}
.fac-star--on{color:#f59e0b;}
.fac-star:hover{transform:scale(1.15);}
.fac-star-label{margin-left:.75rem;font-size:.9rem;font-weight:800;color:var(--f-red);min-width:80px;}

/* ── SUBMIT ── */
.fac-submit-row{display:flex;align-items:center;justify-content:space-between;padding-top:.5rem;}
.fac-back-link{display:inline-flex;align-items:center;gap:.4rem;font-size:.88rem;font-weight:700;color:#9ca3af;text-decoration:none;transition:color .2s;}
.fac-back-link:hover{color:var(--f-red);}
.fac-submit{display:inline-flex;align-items:center;gap:.65rem;padding:1rem 1.75rem;background:var(--f-red);color:#fff;border:none;border-radius:14px;font-size:.95rem;font-weight:800;cursor:pointer;box-shadow:0 8px 28px rgba(135,35,35,.25);transition:.25s var(--f-ease);}
.fac-submit:hover{background:#6f1c1c;transform:translateY(-2px);box-shadow:0 14px 38px rgba(135,35,35,.32);}
.fac-submit:active{transform:translateY(0);}

/* ── PREVIEW ── */
.fac-preview-section{margin-bottom:1.5rem;}
.fac-preview-label{display:flex;align-items:center;gap:.5rem;font-size:.78rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.75rem;}
.fac-preview-card{background:#fff;border:1px solid rgba(135,35,35,.12);border-radius:20px;padding:1.5rem;box-shadow:0 6px 24px rgba(135,35,35,.07);}
.fac-preview__stars{display:flex;gap:3px;margin-bottom:.9rem;}
.fac-preview__text{font-size:.92rem;line-height:1.75;color:#374151;min-height:3rem;margin-bottom:1rem;font-style:italic;}
.fac-preview__footer{display:flex;align-items:center;gap:.75rem;border-top:1px solid rgba(17,17,17,.06);padding-top:.9rem;}
.fac-preview__av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--f-red),#c04040);display:flex;align-items:center;justify-content:center;font-size:.9rem;font-weight:900;color:#fff;flex-shrink:0;}
.fac-preview__footer strong{display:block;font-size:.88rem;color:#111;}
.fac-preview__footer span{font-size:.78rem;color:#9ca3af;}

/* ── FOOTER NAV (re-use fav classes) ── */
.fav-footer-nav{display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap;}
.fav-nav-link{display:inline-flex;align-items:center;gap:.5rem;padding:.8rem 1.3rem;border-radius:12px;text-decoration:none;font-weight:700;font-size:.9rem;border:1px solid rgba(17,17,17,.08);color:#6b7280;background:#fff;transition:.25s var(--f-ease);}
.fav-nav-link:hover{border-color:rgba(135,35,35,.2);color:var(--f-red);}
.fav-nav-link--primary{background:var(--f-red);color:#fff;border-color:var(--f-red);box-shadow:0 8px 28px rgba(135,35,35,.22);}
.fav-nav-link--primary:hover{background:#6f1c1c;transform:translateY(-2px);}
.fav-nav-link--primary svg{transition:transform .25s var(--f-ease);}
.fav-nav-link--primary:hover svg{transform:translateX(4px);}

@media(max-width:640px){
    .fac-row-2{grid-template-columns:1fr;}
    .fac-star svg{width:26px;height:26px;}
    .fac-submit-row{flex-direction:column;gap:1rem;align-items:stretch;}
    .fac-submit{justify-content:center;}
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Scroll reveal
    const obs = new IntersectionObserver(entries => { entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('is-visible'); obs.unobserve(e.target); } }); }, {threshold:0.08});
    document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));

    // Star picker
    const stars   = document.querySelectorAll('.fac-star');
    const noteInp = document.getElementById('noteInput');
    const starLbl = document.getElementById('starLabel');
    const labels  = {1:'Mauvais', 2:'Passable', 3:'Correct', 4:'Bien', 5:'Excellent'};

    function setRating(val){
        noteInp.value = val;
        stars.forEach((s,i) => s.classList.toggle('fac-star--on', i < val));
        starLbl.textContent = labels[val] || '';
        renderPreviewStars(val);
        updateStepIndicator();
    }

    stars.forEach(s => {
        s.addEventListener('click', () => setRating(parseInt(s.dataset.val)));
        s.addEventListener('mouseenter', () => stars.forEach((b,i) => b.classList.toggle('fac-star--on', i < parseInt(s.dataset.val))));
        s.addEventListener('mouseleave', () => setRating(parseInt(noteInp.value)));
    });
    setRating(parseInt(noteInp.value) || 5);

    // Render preview stars
    function renderPreviewStars(val){
        const container = document.getElementById('previewStars');
        if(!container) return;
        container.innerHTML = Array.from({length:5},(_,i) => `
            <svg width="16" height="16" viewBox="0 0 24 24" fill="${i<val?'#f59e0b':'none'}" stroke="${i<val?'#f59e0b':'#d1d5db'}" stroke-width="1.5">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>`).join('');
    }

    // Live preview
    const nomInput = document.getElementById('nom');
    const commentInput = document.getElementById('commentaire');
    const previewText = document.getElementById('previewText');
    const previewNom  = document.getElementById('previewNom');
    const previewAv   = document.getElementById('previewAv');
    const charCount   = document.getElementById('charCount');

    function updatePreview(){
        const nom  = nomInput.value.trim() || 'Votre nom';
        const text = commentInput.value.trim() || 'Votre commentaire apparaîtra ici...';
        previewNom.textContent  = nom;
        previewAv.textContent   = nom.charAt(0).toUpperCase() || '?';
        previewText.textContent = '\u201C' + text.slice(0,200) + (text.length > 200 ? '\u2026' : '') + '\u201D';
        charCount.textContent   = commentInput.value.length;
    }

    nomInput.addEventListener('input', updatePreview);
    commentInput.addEventListener('input', updatePreview);
    updatePreview();

    // Step indicator
    function updateStepIndicator(){
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const step3 = document.getElementById('step-3');
        const nomOk  = nomInput.value.trim().length > 0;
        const mailOk = document.getElementById('email').value.trim().length > 0;
        const noteOk = parseInt(noteInp.value) > 0;
        const textOk = commentInput.value.trim().length >= 10;

        if(nomOk && mailOk){ step1.classList.add('fac-step--done','fac-step--active'); step2.classList.add('fac-step--active'); }
        else{ step1.classList.remove('fac-step--done'); step2.classList.remove('fac-step--active'); }
        if(noteOk && nomOk && mailOk){ step2.classList.add('fac-step--done'); step3.classList.add('fac-step--active'); }
        else{ step2.classList.remove('fac-step--done'); step3.classList.remove('fac-step--active'); }
        if(textOk && noteOk && nomOk && mailOk) step3.classList.add('fac-step--done');
        else step3.classList.remove('fac-step--done');
    }

    nomInput.addEventListener('input', updateStepIndicator);
    document.getElementById('email').addEventListener('input', updateStepIndicator);
    commentInput.addEventListener('input', () => { updatePreview(); updateStepIndicator(); });
    updateStepIndicator();

    // Submit loading state
    document.getElementById('avisForm').addEventListener('submit', () => {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin .8s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Envoi en cours...';
    });
});
</script>
<style>@keyframes spin{to{transform:rotate(360deg)}}</style>
@endpush