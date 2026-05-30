@extends('layouts.app')

@section('title', 'Faire un don — Fidow')

@push('styles')
<style>
:root { --fr: #872323; --frd: #6b1c1c; }

/* ── HERO ── */
.don-hero {
    padding: 7rem 1.5rem 5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    background: transparent;
}
.don-heart {
    display: inline-flex; align-items: center; justify-content: center;
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, #fde8e8, #fecaca);
    margin: 0 auto 1.75rem;
    animation: heartBeat 1.8s ease-in-out infinite;
}
html.dark .don-heart { background: linear-gradient(135deg, #3b0d0d, #5a1515); }
.don-heart svg { color: var(--fr); }
@keyframes heartBeat {
    0%,100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(135,35,35,.3); }
    14%     { transform: scale(1.12); }
    28%     { transform: scale(1); }
    42%     { transform: scale(1.07); }
    70%     { transform: scale(1); box-shadow: 0 0 0 18px rgba(135,35,35,0); }
}
.don-h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800; line-height: 1.1; letter-spacing: -.03em;
    color: #111; margin-bottom: 1rem;
}
html.dark .don-h1 { color: #f3f4f6; }
.don-h1 span {
    background: linear-gradient(135deg, var(--fr), #c04040, #e05555);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.don-sub {
    max-width: 56ch; margin: 0 auto 2.5rem;
    font-size: 1.05rem; line-height: 1.75; color: #6b7280;
}
html.dark .don-sub { color: #9ca3af; }

/* ── MONTANTS ── */
.don-amounts {
    display: flex; flex-wrap: wrap; gap: .75rem; justify-content: center;
    margin-bottom: 2rem;
}
.don-amount {
    padding: .65rem 1.4rem; border-radius: 50px;
    border: 2px solid rgba(135,35,35,.2); background: transparent;
    font-weight: 700; font-size: .9rem; cursor: pointer;
    color: var(--fr); transition: all .2s;
}
.don-amount:hover, .don-amount.active {
    background: var(--fr); color: #fff; border-color: var(--fr);
    transform: translateY(-2px); box-shadow: 0 8px 24px rgba(135,35,35,.3);
}
html.dark .don-amount {
    border-color: rgba(200,80,80,.3); color: #f87171;
    background: rgba(135,35,35,.08);
}
html.dark .don-amount:hover, html.dark .don-amount.active {
    background: var(--fr); color: #fff; border-color: var(--fr);
}

/* ── OPTIONS DE PAIEMENT ── */
.don-section { max-width: 800px; margin: 0 auto; padding: 0 1.5rem 5rem; }
.don-section-title {
    text-align: center; font-size: .75rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase; color: #9ca3af;
    margin-bottom: 1.5rem;
}
.don-methods {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem; margin-bottom: 3rem;
}
.don-method {
    display: flex; flex-direction: column; align-items: center; gap: .85rem;
    padding: 2rem 1.5rem; border-radius: 20px;
    background: rgba(22,22,25,.88);
    backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    border: 1.5px solid rgba(255,255,255,.08);
    text-decoration: none; transition: all .25s;
    box-shadow: 0 4px 20px rgba(0,0,0,.5);
}
.don-method:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(135,35,35,.35);
    border-color: rgba(135,35,35,.4);
}
.don-method__icon {
    width: 56px; height: 56px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
}
.don-method__name { font-weight: 700; font-size: .95rem; color: #111; }
html.dark .don-method__name { color: #f3f4f6; }
.don-method__desc { font-size: .82rem; color: #9ca3af; text-align: center; }
.don-method__cta {
    display: inline-block; padding: .5rem 1.25rem; border-radius: 50px;
    background: var(--fr); color: #fff; font-size: .8rem; font-weight: 700;
    margin-top: .25rem;
}

/* ── IMPACT ── */
.don-impact {
    background: rgba(22,22,25,.88);
    backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    border: 1.5px solid rgba(255,255,255,.08);
    border-radius: 24px; padding: 2.5rem; margin-bottom: 3rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.5);
}
.don-impact__title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.25rem; font-weight: 700; color: #111; margin-bottom: 1.5rem;
}
html.dark .don-impact__title { color: #f3f4f6; }
.don-impact__list { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
.don-impact__item {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: 1rem; border-radius: 12px; background: #fef7f7;
}
html.dark .don-impact__item { background: rgba(135,35,35,.08); }
.don-impact__dot {
    flex-shrink: 0; width: 32px; height: 32px; border-radius: 8px;
    background: rgba(135,35,35,.1); display: flex; align-items: center; justify-content: center;
    color: var(--fr);
}
.don-impact__text { font-size: .875rem; line-height: 1.5; color: #374151; }
html.dark .don-impact__text { color: #d1d5db; }

/* ── TRANSPARENCE ── */
.don-transp {
    background: linear-gradient(135deg, var(--fr), #a03030);
    border-radius: 24px; padding: 2.5rem; color: #fff; text-align: center;
    margin-bottom: 2rem;
}
.don-transp h3 { font-family: 'Space Grotesk', sans-serif; font-size: 1.3rem; font-weight: 800; margin-bottom: .75rem; }
.don-transp p { font-size: .9rem; line-height: 1.7; opacity: .9; max-width: 52ch; margin: 0 auto; }
</style>
@endpush

@section('content')
<div class="don-hero">
    <div class="don-heart">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/>
        </svg>
    </div>
    <h1 class="don-h1">Tu utilises Fidow ?<br><span>Montre ton soutien.</span></h1>
    <p class="don-sub">
        Fidow est entièrement gratuit, sans publicité et sans données vendues.
        Si ces outils t'ont aidé dans ta carrière remote, un petit don fait une vraie différence pour continuer à améliorer la plateforme.
    </p>
    <div class="don-amounts" x-data="{ selected: 5 }">
        <button class="don-amount" :class="{ active: selected === 2 }" @click="selected = 2">2€</button>
        <button class="don-amount" :class="{ active: selected === 5 }" @click="selected = 5">5€</button>
        <button class="don-amount" :class="{ active: selected === 10 }" @click="selected = 10">10€</button>
        <button class="don-amount" :class="{ active: selected === 20 }" @click="selected = 20">20€</button>
        <button class="don-amount" :class="{ active: selected === 0 }" @click="selected = 0">Autre</button>
    </div>
</div>

<div class="don-section">

    <!-- Méthodes de don -->
    <p class="don-section-title">Choisir une méthode</p>
    <div class="don-methods">

        <!-- Ko-fi -->
        <a href="https://ko-fi.com/rogergnanih" target="_blank" rel="noopener noreferrer" class="don-method">
            <div class="don-method__icon" style="background: #fff0e6;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="#FF5E5B">
                    <path d="M23.881 8.948c-.773-4.085-4.859-4.593-4.859-4.593H.723c-.604 0-.679.798-.679.798s-.082 7.324-.022 11.822c.164 2.424 2.586 2.672 2.586 2.672s8.267-.023 11.966-.049c2.438-.426 2.683-2.566 2.658-3.734 4.352.24 7.422-2.831 6.649-6.916zm-11.062 3.511c-1.246 1.453-4.011 3.976-4.011 3.976s-.121.119-.31.023c-.076-.057-.108-.09-.108-.09-.443-.441-3.368-3.049-4.034-3.954-.709-.965-1.041-2.7-.091-3.71.951-1.01 3.005-1.086 4.363.407 0 0 1.565-1.782 3.468-.963 1.904.82 1.832 3.011.723 4.311zm6.173.478c-.928.116-1.682.028-1.682.028V7.284h1.77s1.971.551 1.971 2.638c0 1.913-.985 2.667-2.059 3.015z"/>
                </svg>
            </div>
            <div class="don-method__name">Ko-fi</div>
            <div class="don-method__desc">Don unique ou mensuel, rapide et sans frais</div>
            <span class="don-method__cta">Soutenir sur Ko-fi</span>
        </a>

        <!-- PayPal -->
        <a href="https://paypal.me/rogergnanih" target="_blank" rel="noopener noreferrer" class="don-method">
            <div class="don-method__icon" style="background: #e8f0fe;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="#0070E0">
                    <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                </svg>
            </div>
            <div class="don-method__name">PayPal</div>
            <div class="don-method__desc">Paiement sécurisé, carte ou solde PayPal</div>
            <span class="don-method__cta">Donner via PayPal</span>
        </a>

        <!-- GitHub Sponsors -->
        <a href="https://github.com/sponsors/rogerfarolx" target="_blank" rel="noopener noreferrer" class="don-method">
            <div class="don-method__icon" style="background: #f6f8fa;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="#24292f">
                    <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                </svg>
            </div>
            <div class="don-method__name">GitHub Sponsors</div>
            <div class="don-method__desc">Sponsorship mensuel pour soutenir le dev</div>
            <span class="don-method__cta">Sponsoriser sur GitHub</span>
        </a>

    </div>

    <!-- Impact -->
    <div class="don-impact">
        <div class="don-impact__title">À quoi sert votre don ?</div>
        <div class="don-impact__list">
            <div class="don-impact__item">
                <div class="don-impact__dot">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </div>
                <div class="don-impact__text"><strong>Serveur & hébergement</strong> — maintenir Fidow en ligne 24/7</div>
            </div>
            <div class="don-impact__item">
                <div class="don-impact__dot">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div class="don-impact__text"><strong>APIs IA</strong> — améliorer le générateur de positionnement</div>
            </div>
            <div class="don-impact__item">
                <div class="don-impact__dot">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="don-impact__text"><strong>Nouveaux outils</strong> — accélérer le développement de fonctionnalités</div>
            </div>
            <div class="don-impact__item">
                <div class="don-impact__dot">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="don-impact__text"><strong>RemoteDigest</strong> — élargir les sources d'offres remote</div>
            </div>
        </div>
    </div>

    <!-- Transparence -->
    <div class="don-transp">
        <h3>100 % transparent</h3>
        <p>
            Fidow n'a pas d'investisseurs, pas de publicité, pas de freemium caché. Les dons couvrent les coûts réels
            — ce que tu vois sur la plateforme est tout ce qu'il y a. Merci de faire partie de l'aventure.
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:inline;vertical-align:middle;color:rgba(255,255,255,.8)"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
        </p>
    </div>

</div>
@endsection
