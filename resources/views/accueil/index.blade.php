@extends('layouts.app')

@section('title', 'Fidow - Suite d\'Outils pour Professionnels Remote')

@section('content')

<!-- ═══════════════════════════════════════════
     HERO — light theme, spiral canvas BG
═══════════════════════════════════════════ -->
<section class="fhero">

    <div class="fhero__bg" aria-hidden="true">
        <canvas id="smokeCanvas"></canvas>
        <div class="fring fring--1"></div>
        <div class="fring fring--2"></div>
        <div class="fring fring--3"></div>
        <div class="fblob fblob--top"></div>
        <div class="fblob fblob--right"></div>
    </div>

    {{-- Photo hero — visible desktop uniquement --}}
    <div class="fhero__photo" aria-hidden="true">
        <img src="{{ asset('assets/1.webp') }}"
             alt=""
             width="600" height="700"
             class="fhero__photo-img">
        <div class="fhero__photo-vignette"></div>
    </div>

    <div class="fhero__inner">

        <div class="fpill" data-reveal>
            <span class="fpill__dot"></span>
            Cotonou · Dakar · Abidjan · Lomé · Accra · Lagos &nbsp;— &nbsp;Gratuit · Sans inscription
        </div>

        <h1 class="fhero__h1" data-reveal data-reveal-delay="1">
            Le kit de survie du<br>
            <span class="fhero__accent">professionnel remote africain</span>
        </h1>

        <p class="fhero__sub" data-reveal data-reveal-delay="2">
            Positionne-toi, trouve des missions, calcule ton tarif, améliore ton LinkedIn. Tout ce qu'il faut pour décrocher des clients internationaux — depuis n'importe où en Afrique.
        </p>

        <div class="fhero__ctas" data-reveal data-reveal-delay="3">
            <a href="#commencer" class="fcta fcta--primary">
                Commencer maintenant
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="#outils" class="fcta fcta--outline">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                Voir les outils
            </a>
        </div>

        <div class="fstats" data-reveal data-reveal-delay="4">
            <div class="fstat">
                <span class="fstat__n" data-count="{{ $totalGenerations }}">0</span>
                <span class="fstat__l">Générations</span>
            </div>
            <div class="fstat__sep"></div>
            <div class="fstat">
                <span class="fstat__n" data-count="{{ $totalUsages }}">0</span>
                <span class="fstat__l">Utilisations</span>
            </div>
            <div class="fstat__sep"></div>
            <div class="fstat">
                <span class="fstat__n">{{ $totalAvis }}</span>
                <span class="fstat__l">Avis</span>
            </div>
        </div>

    </div>

    <div class="fscroll" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     STRIP
═══════════════════════════════════════════ -->
<div class="fstrip">
    <div class="fstrip__track">
        @php
        $stripItems = [
            ['BJ','Cotonou'],['SN','Dakar'],['CI','Abidjan'],['TG','Lomé'],
            ['GH','Accra'],['NG','Lagos'],['BF','Ouagadougou'],['CM','Douala'],
            ['ML','Bamako'],['GN','Conakry'],['NE','Niamey'],['MA','Casablanca'],
        ];
        @endphp
        @foreach(array_merge($stripItems,$stripItems) as $c)
        <span class="fstrip__item">
            <span class="fstrip__code">{{ $c[0] }}</span>
            {{ $c[1] }}
        </span>
        <span class="fstrip__sep">·</span>
        @endforeach
    </div>
</div>


<!-- ═══════════════════════════════════════════
     WHY SECTION
═══════════════════════════════════════════ -->
<section class="fsec fsec--off">
    <div class="fcont">
        <div class="fwhy">

            <div class="fwhy__left" data-reveal>
                <div class="feyebrow">Notre approche</div>
                <h2 class="fsec__h2">
                    Pensé pour les<br>professionnels du<br>
                    <span class="facc">remote africain</span>
                </h2>
                <div class="fwhy__mockup" aria-hidden="true">
                    <svg viewBox="0 0 260 190" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Device frame -->
                        <rect x="10" y="10" width="240" height="155" rx="14" fill="white" stroke="rgba(135,35,35,.12)" stroke-width="1.5"/>
                        <rect x="10" y="10" width="240" height="30" rx="14" fill="rgba(135,35,35,.04)" stroke="none"/>
                        <rect x="10" y="25" width="240" height="15" fill="rgba(135,35,35,.04)" stroke="none"/>
                        <!-- Browser dots -->
                        <circle cx="27" cy="25" r="4" fill="rgba(135,35,35,.2)"/>
                        <circle cx="40" cy="25" r="4" fill="rgba(135,35,35,.12)"/>
                        <circle cx="53" cy="25" r="4" fill="rgba(135,35,35,.08)"/>
                        <!-- URL bar -->
                        <rect x="68" y="18" width="110" height="14" rx="7" fill="rgba(135,35,35,.06)"/>
                        <!-- Content lines -->
                        <rect x="30" y="58" width="140" height="10" rx="5" fill="rgba(135,35,35,.12)"/>
                        <rect x="30" y="76" width="100" height="7" rx="3.5" fill="rgba(135,35,35,.07)"/>
                        <rect x="30" y="90" width="120" height="7" rx="3.5" fill="rgba(135,35,35,.07)"/>
                        <!-- Card -->
                        <rect x="30" y="110" width="90" height="42" rx="8" fill="rgba(135,35,35,.06)" stroke="rgba(135,35,35,.1)" stroke-width="1"/>
                        <rect x="40" y="120" width="50" height="6" rx="3" fill="rgba(135,35,35,.15)"/>
                        <rect x="40" y="133" width="35" height="5" rx="2.5" fill="rgba(135,35,35,.08)"/>
                        <!-- Check badge -->
                        <circle cx="185" cy="131" r="22" fill="rgba(135,35,35,.07)" stroke="rgba(135,35,35,.15)" stroke-width="1.5"/>
                        <path d="M175 131l7 7 13-13" stroke="#872323" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <!-- Bottom bar -->
                        <rect x="10" y="155" width="240" height="10" rx="0" fill="rgba(135,35,35,.04)"/>
                        <rect x="10" y="158" width="240" height="7" rx="0" fill="rgba(135,35,35,.03)"/>
                        <rect x="10" y="155" width="240" height="10" rx="0" fill="none" stroke="rgba(135,35,35,.1)" stroke-width="0"/>
                        <!-- Sparkles -->
                        <circle cx="220" cy="60" r="3" fill="rgba(135,35,35,.25)"/>
                        <circle cx="228" cy="75" r="2" fill="rgba(135,35,35,.15)"/>
                        <circle cx="215" cy="80" r="1.5" fill="rgba(135,35,35,.2)"/>
                    </svg>
                </div>
            </div>

            <div class="fwhy__right" data-reveal data-reveal-delay="1">
                <p class="fwhy__p">Les outils existants sont pensés pour un contexte occidental. Fidow tient compte des réalités locales — connectivité, marchés, langues — pour te donner des résultats qui fonctionnent là où tu es.</p>
                <div class="fwhy__cards">

                    <div class="fwhy__card" data-reveal data-reveal-delay="1">
                        <div class="fwhy__card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        </div>
                        <div>
                            <div class="fwhy__card-title">Immédiat</div>
                            <div class="fwhy__card-desc">Pas de compte, pas d'email. Tu arrives, tu utilises.</div>
                        </div>
                    </div>

                    <div class="fwhy__card" data-reveal data-reveal-delay="2">
                        <div class="fwhy__card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div>
                            <div class="fwhy__card-title">Toujours gratuit</div>
                            <div class="fwhy__card-desc">Aucune fonctionnalité cachée derrière un paywall.</div>
                        </div>
                    </div>

                    <div class="fwhy__card" data-reveal data-reveal-delay="3">
                        <div class="fwhy__card-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="9" height="9" rx="1"/><rect x="13" y="2" width="9" height="9" rx="1"/><rect x="2" y="13" width="9" height="9" rx="1"/><rect x="13" y="13" width="9" height="9" rx="1"/></svg>
                        </div>
                        <div>
                            <div class="fwhy__card-title">Outils mixtes</div>
                            <div class="fwhy__card-desc">IA ou no-code, l'important c'est que ça serve.</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     TOOLS SECTION
═══════════════════════════════════════════ -->
<!-- ── Dashboard Mockup ── -->
<div class="fmockup-strip">
    <div class="fmockup-browser" data-reveal>
        <div class="fmockup-topbar">
            <div class="fmockup-dot fmockup-dot--r"></div>
            <div class="fmockup-dot fmockup-dot--y"></div>
            <div class="fmockup-dot fmockup-dot--g"></div>
            <div class="fmockup-url">fidow.nealix.org/positionnement</div>
        </div>
        <div class="fmockup-body">
            <div class="fmockup-body-grid">
                <div class="fmockup-kpi"><div class="fmockup-kpi__n">{{ $totalGenerations }}</div><div class="fmockup-kpi__l">Générations IA</div></div>
                <div class="fmockup-kpi"><div class="fmockup-kpi__n">{{ $totalUsages }}</div><div class="fmockup-kpi__l">Utilisations</div></div>
                <div class="fmockup-kpi"><div class="fmockup-kpi__n">{{ $totalAvis }}</div><div class="fmockup-kpi__l">Avis vérifiés</div></div>
                <div class="fmockup-kpi"><div class="fmockup-kpi__n">{{ $metiersDistincts }}</div><div class="fmockup-kpi__l">Métiers</div></div>
            </div>
            <div class="fmockup-row">
                <div class="fmockup-chart">
                    <div class="fmockup-chart__title">ACTIVITÉ · 7 DERNIERS JOURS</div>
                    <div class="fmockup-bars">
                        <div class="fmockup-bar-item"></div>
                        <div class="fmockup-bar-item"></div>
                        <div class="fmockup-bar-item"></div>
                        <div class="fmockup-bar-item"></div>
                        <div class="fmockup-bar-item"></div>
                        <div class="fmockup-bar-item"></div>
                        <div class="fmockup-bar-item"></div>
                    </div>
                </div>
                <div class="fmockup-list">
                    <div class="fmockup-list__title">DERNIÈRES GÉNÉRATIONS</div>
                    @foreach(['Dev Laravel · Dakar','UX Design · Abidjan','Data Analyst · Tunis','Product Manager · Lagos','Fullstack · Casablanca'] as $item)
                    <div class="fmockup-list-item">
                        <div class="fmockup-list-dot"></div>
                        <div class="fmockup-list-line" style="width:{{ rand(40,90) }}%"></div>
                        <span style="font-size:.62rem;color:#9ca3af;white-space:nowrap">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<section class="fsec fsec--tools" id="outils">

    <div class="ftools__bg" aria-hidden="true">
        <svg class="ftools__circles" viewBox="0 0 600 600" fill="none">
            <circle cx="300" cy="300" r="260" stroke="rgba(135,35,35,0.08)" stroke-width="1"/>
            <circle cx="300" cy="300" r="210" stroke="rgba(135,35,35,0.08)" stroke-width="1"/>
            <circle cx="300" cy="300" r="160" stroke="rgba(135,35,35,0.07)" stroke-width="1"/>
            <circle cx="300" cy="300" r="110" stroke="rgba(135,35,35,0.07)" stroke-width="1"/>
            <circle cx="300" cy="300" r="60"  stroke="rgba(135,35,35,0.06)" stroke-width="1"/>
            <line x1="300" y1="40"  x2="300" y2="560" stroke="rgba(135,35,35,0.07)" stroke-width="1"/>
            <line x1="40"  y1="300" x2="560" y2="300" stroke="rgba(135,35,35,0.07)" stroke-width="1"/>
            <line x1="114" y1="114" x2="486" y2="486" stroke="rgba(135,35,35,0.05)" stroke-width="1"/>
            <line x1="486" y1="114" x2="114" y2="486" stroke="rgba(135,35,35,0.05)" stroke-width="1"/>
        </svg>
        <svg class="ftools__wave" viewBox="0 0 1440 180" preserveAspectRatio="none">
            <path d="M0,90L60,80C120,70,240,50,360,60C480,70,600,110,720,115C840,120,960,90,1080,75C1200,60,1320,70,1380,75L1440,80L1440,180L0,180Z" fill="rgba(135,35,35,0.06)"/>
        </svg>
    </div>

    <div class="fcont">
        <div class="fsec__header" data-reveal>
            <div class="feyebrow">Nos outils</div>
            <h2 class="fsec__h2">
                Une boîte à outils qui<br>
                <span class="facc">grandit avec toi</span>
            </h2>
            <p class="fsec__sub">Certains outils utilisent l'IA, d'autres non — tous conçus pour t'aider à avancer concrètement.</p>
        </div>

        <div class="ftools__grid">

            <div class="ftool ftool--active" data-reveal>
                <div class="ftool__top">
                    <div class="ftool__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <span class="ftool__live">
                        <span class="ftool__live-dot"></span>
                        Disponible
                    </span>
                </div>
                <div class="ftool__tag">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    IA
                </div>
                <h3 class="ftool__name">Positionnement Pro</h3>
                <p class="ftool__desc">Génère des phrases de positionnement percutantes pour te démarquer sur LinkedIn, ton portfolio ou en candidature.</p>
                <ul class="ftool__list">
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        3 variantes de style différentes
                    </li>
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Conseils personnalisés inclus
                    </li>
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Propulsé par l'IA
                    </li>
                </ul>
                <a href="{{ route('positionnement') }}" class="ftool__cta">
                    Essayer maintenant
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <div class="ftool__deco" aria-hidden="true">
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-dot"></div>
                </div>
            </div>


            {{-- ── OUTIL 2 : RemoteDigest (actif) ── --}}
            <div class="ftool ftool--active" data-reveal data-reveal-delay="1">
                <div class="ftool__top">
                    <div class="ftool__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <span class="ftool__live">
                        <span class="ftool__live-dot"></span>
                        Disponible
                    </span>
                </div>
                <div class="ftool__tag">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Scraping + IA
                </div>
                <h3 class="ftool__name">RemoteDigest</h3>
                <p class="ftool__desc">20 offres remote sélectionnées par l'IA, livrées chaque soir dans ta boîte mail. Scraping de 5+ sources. Jamais les mêmes offres deux fois.</p>
                <ul class="ftool__list">
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        5 sources scrapées chaque jour
                    </li>
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Matching IA sur ton profil exact
                    </li>
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Anti-doublon garanti · 0 compte requis
                    </li>
                </ul>
                <a href="{{ route('digest.index') }}" class="ftool__cta">
                    S'abonner gratuitement
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <div class="ftool__deco" aria-hidden="true">
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-dot"></div>
                </div>
            </div>


            {{-- ── Simulateur TJM ── --}}
            <div class="ftool ftool--active" data-reveal data-reveal-delay="2">
                <div class="ftool__top">
                    <div class="ftool__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <span class="ftool__live">
                        <span class="ftool__live-dot"></span>
                        Live
                    </span>
                </div>
                <div class="ftool__tag">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    No code · Calcul instant
                </div>
                <h3 class="ftool__name">Simulateur TJM</h3>
                <p class="ftool__desc">Calcule ton tarif journalier freelance idéal selon ton pays, ta stack et ton expérience. Résultat en temps réel.</p>
                <ul class="ftool__list">
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        14 pays couverts (Europe + Afrique)
                    </li>
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        12 stacks techniques
                    </li>
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Revenu mensuel & annuel estimé
                    </li>
                </ul>
                <a href="{{ route('tjm.index') }}" class="ftool__cta">
                    Calculer mon TJM
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <div class="ftool__deco" aria-hidden="true">
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-dot"></div>
                </div>
            </div>

            {{-- ── Analyse LinkedIn ── --}}
            <div class="ftool ftool--active" data-reveal data-reveal-delay="3">
                <div class="ftool__top">
                    <div class="ftool__icon" style="background:rgba(10,102,194,.1);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="rgba(10,102,194,.9)"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </div>
                    <span class="ftool__live">
                        <span class="ftool__live-dot"></span>
                        IA
                    </span>
                </div>
                <div class="ftool__tag" style="color:#0a66c2;background:rgba(10,102,194,.07);border-color:rgba(10,102,194,.15);">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Analyse IA · Score / 100
                </div>
                <h3 class="ftool__name">Analyse LinkedIn</h3>
                <p class="ftool__desc">Colle ton profil LinkedIn, l'IA l'analyse et te donne un score + 5 recommandations concrètes pour attirer plus de clients et recruteurs.</p>
                <ul class="ftool__list">
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Score global + 5 catégories
                    </li>
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        5 recommandations prioritisées
                    </li>
                    <li>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        3 actions immédiates
                    </li>
                </ul>
                <a href="{{ route('linkedin.analyse') }}" class="ftool__cta" style="background:#0a66c2;">
                    Analyser mon profil
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <div class="ftool__deco" aria-hidden="true">
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-line"></div>
                    <div class="ftool__deco-dot"></div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     STATS ROW
═══════════════════════════════════════════ -->
<section class="fsec fsec--stat-row">
    <div class="fcont">
        <div class="fstat-row" data-reveal>
            <div class="fstat-big">
                <div class="fstat-big__n" data-count="{{ $totalGenerations }}">0</div>
                <div class="fstat-big__l">Contenus générés</div>
            </div>
            <div class="fstat-row__sep"></div>
            <div class="fstat-big">
                <div class="fstat-big__n" data-count="{{ $totalUsages }}">0</div>
                <div class="fstat-big__l">Utilisations totales</div>
            </div>
            <div class="fstat-row__sep"></div>
            <div class="fstat-big">
                <div class="fstat-big__n" data-count="{{ $metiersDistincts }}">0</div>
                <div class="fstat-big__l">Métiers représentés</div>
            </div>
            <div class="fstat-row__sep"></div>
            <div class="fstat-big">
                <div class="fstat-big__n">{{ $totalAvis }}</div>
                <div class="fstat-big__l">Avis vérifiés</div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     AFRICA ADVANTAGE SECTION
═══════════════════════════════════════════ -->
<section class="fafrica" style="background-image:url('{{ asset('assets/4.webp') }}');background-size:cover;background-position:center;">
    <div class="fafrica__bg-overlay"></div>
    <div class="fcont" style="position:relative;z-index:1;">
        <div class="fafrica__grid">
            <div class="fafrica__left" data-reveal>
                <div class="feyebrow" style="color:#d97706;">L'avantage géographique</div>
                <h2 class="fsec__h2" style="color:#fff;">
                    Depuis l'Afrique,<br>
                    <span style="background:linear-gradient(135deg,#d97706,#f59e0b,#fcd34d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">vers le monde entier</span>
                </h2>
                <p style="color:rgba(255,255,255,.75);font-size:.95rem;line-height:1.75;max-width:48ch;margin-bottom:2rem;">
                    Les freelances africains ont un avantage compétitif unique : tarifs attractifs pour les clients européens, fort pouvoir d'achat local, maîtrise du français et de l'anglais, et une nouvelle génération de talents techniques qui n'a rien à envier à personne.
                </p>
                <div class="fafrica__stats">
                    <div class="fafrica__stat">
                        <div class="fafrica__stat-n">+340%</div>
                        <div class="fafrica__stat-l">croissance du remote tech en Afrique (2020–2024)</div>
                    </div>
                    <div class="fafrica__stat">
                        <div class="fafrica__stat-n">3-5×</div>
                        <div class="fafrica__stat-l">pouvoir d'achat local vs tarif client européen</div>
                    </div>
                    <div class="fafrica__stat">
                        <div class="fafrica__stat-n">54</div>
                        <div class="fafrica__stat-l">pays, une seule communauté remote</div>
                    </div>
                </div>
            </div>

            <div class="fafrica__right" data-reveal data-reveal-delay="1">
                <div class="fafrica__cities">
                    @foreach([
                        ['code'=>'BJ','city'=>'Cotonou','job'=>'Dev Laravel',    'highlight'=>true],
                        ['code'=>'SN','city'=>'Dakar',   'job'=>'Fullstack JS',  'highlight'=>false],
                        ['code'=>'CI','city'=>'Abidjan', 'job'=>'UX Designer',   'highlight'=>false],
                        ['code'=>'TG','city'=>'Lomé',    'job'=>'Dev Mobile',    'highlight'=>false],
                        ['code'=>'GH','city'=>'Accra',   'job'=>'Data Analyst',  'highlight'=>false],
                        ['code'=>'NG','city'=>'Lagos',   'job'=>'Product Manager','highlight'=>false],
                        ['code'=>'BF','city'=>'Ouagadougou','job'=>'DevOps',     'highlight'=>false],
                        ['code'=>'CM','city'=>'Douala',  'job'=>'Cybersécurité', 'highlight'=>false],
                    ] as $i => $city)
                    <div class="fafrica__city {{ $city['highlight'] ? 'fafrica__city--home' : '' }}"
                         style="animation-delay:{{ $i * 0.08 }}s">
                        <span class="fafrica__city-code {{ $city['highlight'] ? 'fafrica__city-code--home' : '' }}">
                            {{ $city['code'] }}
                        </span>
                        <div>
                            <div class="fafrica__city-name">
                                {{ $city['city'] }}
                                @if($city['highlight'])
                                    <span class="fafrica__city-home-tag">Home</span>
                                @endif
                            </div>
                            <div class="fafrica__city-job">{{ $city['job'] }}</div>
                        </div>
                        <div class="fafrica__city-dot"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     COMMUNAUTÉ PHOTO BAND
═══════════════════════════════════════════ -->
<div class="fcommunity-band" data-reveal>
    <div class="fcommunity-band__img">
        <img src="{{ asset('assets/5.webp') }}"
             alt="Communauté remote Afrique de l'Ouest"
             width="1200" height="500"
             loading="lazy">
        <div class="fcommunity-band__overlay">
            <div class="fcommunity-band__text">
                <div style="font-size:.72rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:.6rem;">Communauté</div>
                <div style="font-family:'Space Grotesk',sans-serif;font-size:clamp(1.4rem,3vw,2.2rem);font-weight:900;color:#fff;line-height:1.1;">
                    Des professionnels du<br>
                    <span style="background:linear-gradient(135deg,#d97706,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">remote africain</span>
                </div>
                <div style="margin-top:1rem;">
                    <a href="{{ route('avis.index') }}"
                       style="display:inline-flex;align-items:center;gap:.5rem;padding:.65rem 1.4rem;border-radius:50px;background:rgba(255,255,255,.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.2);color:#fff;font-size:.82rem;font-weight:700;text-decoration:none;transition:all .2s;"
                       onmouseover="this.style.background='rgba(255,255,255,.22)'"
                       onmouseout="this.style.background='rgba(255,255,255,.12)'">
                        Voir les avis
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════ -->
<section class="fsec" id="avis">
    <div class="fcont">
        <div class="fsec__header" data-reveal>
            <div class="feyebrow">Avis</div>
            <h2 class="fsec__h2">Ce qu'ils en disent</h2>
        </div>

        <div class="ftesti-grid">
            @forelse($recentAvis as $item)
            <div class="ftesti {{ $loop->first ? 'ftesti--feat' : '' }}" data-reveal data-reveal-delay="{{ $loop->index }}">
                @if($loop->first)
                <div class="ftesti__bigquote" aria-hidden="true">"</div>
                @endif
                <div class="ftesti__stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= $item->note ? '#f59e0b' : 'none' }}" stroke="{{ $i <= $item->note ? '#f59e0b' : '#d1d5db' }}" stroke-width="1.5">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    @endfor
                </div>
                <p class="ftesti__text">"{{ Str::limit($item->commentaire, 180) }}"</p>
                <div class="ftesti__who">
                    @php
                        $colors = [
                            ['#872323','#c04040'], ['#1e3a5f','#2d6a9f'], ['#1a5c3a','#2d8a5a'],
                            ['#5b21b6','#7c3aed'], ['#d97706','#b45309']
                        ];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    <div class="ftesti__av" style="background:linear-gradient(135deg,{{ $color[0] }},{{ $color[1] }})">
                        {{ strtoupper(substr($item->nom, 0, 1)) }}
                    </div>
                    <div>
                        <div class="ftesti__name">{{ $item->nom }}</div>
                        <div class="ftesti__role">{{ $item->created_at->diffForHumans() }} · Note {{ $item->note }}/5</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="ftesti ftesti--feat" data-reveal>
                <p class="ftesti__text">Aucun avis pour le moment. Soyez le premier à donner votre avis !</p>
            </div>
            @endforelse
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════
     CTA CARD
═══════════════════════════════════════════ -->
<section class="fsec fsec--cta-wrap" id="commencer">
    <div class="fcont">
        <div class="fcta-card" data-reveal>
            <div class="fcta-card__deco" aria-hidden="true">
                <svg viewBox="0 0 600 600" fill="none">
                    <circle cx="300" cy="300" r="260" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
                    <circle cx="300" cy="300" r="200" stroke="rgba(255,255,255,0.12)" stroke-width="1"/>
                    <circle cx="300" cy="300" r="140" stroke="rgba(255,255,255,0.09)" stroke-width="1"/>
                    <circle cx="300" cy="300" r="80"  stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
                    <line x1="300" y1="40"  x2="300" y2="560" stroke="rgba(255,255,255,0.08)" stroke-width="1"/>
                    <line x1="40"  y1="300" x2="560" y2="300" stroke="rgba(255,255,255,0.08)" stroke-width="1"/>
                    <line x1="114" y1="114" x2="486" y2="486" stroke="rgba(255,255,255,0.06)" stroke-width="1"/>
                    <line x1="486" y1="114" x2="114" y2="486" stroke="rgba(255,255,255,0.06)" stroke-width="1"/>
                </svg>
            </div>
            <div class="fcta-card__glow" aria-hidden="true"></div>
            <div class="fcta-card__inner">
                <div class="feyebrow feyebrow--light">Prêt à commencer ?</div>
                <h2 class="fcta-card__title">Lance-toi dès maintenant.</h2>
                <p class="fcta-card__sub">Gratuit, sans compte, sans limite. Tes premiers résultats en moins d'une minute.</p>
                <div class="fcta-card__actions">
                    <a href="{{ route('positionnement') }}" class="fcta fcta--white">
                        Commencer avec Positionnement Pro
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#outils" class="fcta fcta--ghost-light">
                        Voir tous les outils
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ═══════════════════════════════════════════════════════════════
   FIDOW HOME — COMPLETE STYLESHEET
   Africa-first · Thème clair/sombre #872323 · Animated
════════════════════════════════════════════════════════════════ */

/* ── AFRICA ADVANTAGE SECTION ──────────────────────────────── */
.fafrica {
    background:linear-gradient(135deg,#0f0208 0%,#1a0505 40%,#0d0f05 80%,#050e0a 100%);
    position:relative; overflow:hidden;
    padding:5rem 2rem;
}
.fafrica::before {
    content:''; position:absolute; inset:0;
    background-image:radial-gradient(rgba(217,119,6,.08) 1.5px,transparent 1.5px);
    background-size:36px 36px;
    pointer-events:none;
}
.fafrica::after {
    content:''; position:absolute;
    width:700px; height:600px; border-radius:50%;
    background:radial-gradient(ellipse,rgba(217,119,6,.12) 0%,transparent 70%);
    top:-200px; right:-200px;
    pointer-events:none;
}
.fafrica__grid {
    display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center;
    max-width:1100px; margin:0 auto; position:relative; z-index:1;
}
@media(max-width:800px){ .fafrica__grid{ grid-template-columns:1fr; gap:2.5rem; } }

.fafrica__stats { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
@media(max-width:480px){ .fafrica__stats{ grid-template-columns:1fr; } }

.fafrica__stat {
    padding:1rem 1.1rem; border-radius:14px;
    background:rgba(217,119,6,.08); border:1px solid rgba(217,119,6,.2);
}
.fafrica__stat-n {
    font-family:'Space Grotesk',sans-serif;
    font-size:1.6rem; font-weight:900; color:#f59e0b; line-height:1; margin-bottom:.3rem;
}
.fafrica__stat-l { font-size:.72rem; color:rgba(255,255,255,.6); line-height:1.4; }

/* City cards */
.fafrica__cities {
    display:grid; grid-template-columns:1fr 1fr; gap:.6rem;
}
.fafrica__city {
    display:flex; align-items:center; gap:.65rem;
    padding:.8rem 1rem; border-radius:14px;
    background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08);
    transition:all .25s; cursor:default;
    animation:cityFadeIn .5s var(--ease,cubic-bezier(.16,1,.3,1)) both;
}
@keyframes cityFadeIn { from{opacity:0;transform:translateY(10px)} }
.fafrica__city:hover { background:rgba(217,119,6,.1); border-color:rgba(217,119,6,.3); transform:translateY(-2px); }
.fafrica__city-flag { font-size:1.4rem; flex-shrink:0; }
.fafrica__city-name { font-weight:700; font-size:.82rem; color:#fff; line-height:1; margin-bottom:.15rem; }
.fafrica__city-job { font-size:.72rem; color:rgba(255,255,255,.5); }
.fafrica__city-dot {
    width:6px; height:6px; border-radius:50%; background:#22c55e;
    flex-shrink:0; margin-left:auto;
    box-shadow:0 0 0 2px rgba(34,197,94,.3);
    animation:cityDotPulse 2s ease-in-out infinite;
}
@keyframes cityDotPulse { 0%,100%{box-shadow:0 0 0 2px rgba(34,197,94,.3)} 50%{box-shadow:0 0 0 6px rgba(34,197,94,.05)} }

/* ── HERO PHOTO (desktop) ──────────────────────────────────── */
.fhero__photo {
    display:none;
    position:absolute;
    right:0; top:0; bottom:0;
    width:42%; max-width:560px;
    overflow:hidden; z-index:0;
}
@media(min-width:1080px) { .fhero__photo { display:block; } }
.fhero__photo-img {
    width:100%; height:100%; object-fit:cover; object-position:center top;
}
.fhero__photo-vignette {
    position:absolute; inset:0;
    background:linear-gradient(
        to right,
        #0c0c0f 0%,
        rgba(12,12,15,.7) 30%,
        transparent 60%
    );
}
/* Sur desktop, décaler le contenu à gauche pour laisser de la place à la photo */
@media(min-width:1080px){
    .fhero__inner {
        margin-left:0; margin-right:auto;
        text-align:left;
        align-items:flex-start;
        max-width:55%;
    }
    .fhero__ctas { justify-content:flex-start; }
    .fhero__sub { margin-left:0; }
    .fstats { justify-content:flex-start; }
}

/* ── COMMUNITY BAND ─────────────────────────────────────────── */
.fcommunity-band { overflow:hidden; }
.fcommunity-band__img {
    position:relative; height:320px; overflow:hidden;
}
@media(min-width:768px){ .fcommunity-band__img { height:400px; } }
.fcommunity-band__img img {
    width:100%; height:100%; object-fit:cover; object-position:center;
    transition:transform .8s ease;
}
.fcommunity-band:hover .fcommunity-band__img img { transform:scale(1.03); }
.fcommunity-band__overlay {
    position:absolute; inset:0;
    background:linear-gradient(
        135deg,
        rgba(10,4,2,.75) 0%,
        rgba(15,8,2,.6) 40%,
        rgba(5,10,5,.55) 100%
    );
    display:flex; align-items:center; justify-content:center;
    padding:2rem;
}
.fcommunity-band__text { max-width:520px; text-align:center; }

/* ── ANIMATED STRIP (Africa cities scrolling) ──────────────── */
.fstrip { overflow:hidden; white-space:nowrap; }
.fstrip__track {
    display:inline-flex; align-items:center; gap:1.5rem;
    animation:stripScroll 35s linear infinite;
    padding:0 1rem;
}
@keyframes stripScroll { from{transform:translateX(0)} to{transform:translateX(-50%)} }
.fstrip:hover .fstrip__track { animation-play-state:paused; }

/* ── HERO IMPROVEMENTS ──────────────────────────────────────── */
.fhero__h1 {
    font-family:'Space Grotesk',sans-serif;
}

/* ── TOOL CARDS — mini illustrations ───────────────────────── */
.ftool {
    position:relative;
    transition:transform .25s cubic-bezier(.16,1,.3,1), box-shadow .25s;
}
.ftool:hover { transform:translateY(-4px); }

/* ── MOCKUP DASHBOARD SECTION (before tools) ───────────────── */
.fmockup-strip {
    padding:2rem 1.25rem; overflow:hidden;
    display:flex; justify-content:center;
}
.fmockup-browser {
    width:100%; max-width:860px;
    background:#fff; border-radius:16px;
    border:1.5px solid rgba(0,0,0,.08);
    box-shadow:0 32px 80px rgba(0,0,0,.12), 0 4px 16px rgba(0,0,0,.06);
    overflow:hidden;
    transform:perspective(1200px) rotateX(3deg);
    transition:transform .6s;
}
html.dark .fmockup-browser { background:#161619; border-color:rgba(255,255,255,.08); box-shadow:0 32px 80px rgba(0,0,0,.5); }
.fmockup-browser:hover { transform:perspective(1200px) rotateX(0deg); }
.fmockup-topbar {
    height:36px; background:#f3f4f6; border-bottom:1px solid rgba(0,0,0,.07);
    display:flex; align-items:center; padding:0 1rem; gap:.4rem;
}
html.dark .fmockup-topbar { background:#111; border-color:rgba(255,255,255,.06); }
.fmockup-dot { width:10px; height:10px; border-radius:50%; }
.fmockup-dot--r { background:#fe5f57; }
.fmockup-dot--y { background:#febc2e; }
.fmockup-dot--g { background:#28c840; }
.fmockup-url {
    flex:1; height:20px; border-radius:6px; background:rgba(0,0,0,.06);
    font-size:.68rem; color:#9ca3af; display:flex; align-items:center; padding:0 .6rem;
    margin:0 .75rem; max-width:220px;
}
.fmockup-body { padding:1.25rem 1.5rem; }
.fmockup-body-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1rem; }
@media(max-width:500px){ .fmockup-body-grid{ grid-template-columns:repeat(2,1fr); } }
.fmockup-kpi {
    background:rgba(135,35,35,.04); border-radius:10px; padding:.85rem;
    border:1px solid rgba(135,35,35,.08);
}
html.dark .fmockup-kpi { background:rgba(135,35,35,.08); border-color:rgba(200,60,60,.12); }
.fmockup-kpi__n { font-family:'Space Grotesk',sans-serif; font-size:1.4rem; font-weight:900; color:var(--fr,#872323); margin-bottom:.2rem; }
.fmockup-kpi__l { font-size:.68rem; color:#9ca3af; }
.fmockup-row { display:flex; gap:1rem; }
.fmockup-chart { flex:2; background:rgba(135,35,35,.03); border-radius:10px; padding:1rem; border:1px solid rgba(135,35,35,.06); }
html.dark .fmockup-chart { background:rgba(135,35,35,.06); }
.fmockup-chart__title { font-size:.7rem; font-weight:700; color:#6b7280; margin-bottom:.75rem; }
.fmockup-bars { display:flex; align-items:flex-end; gap:.35rem; height:60px; }
.fmockup-bar-item { flex:1; border-radius:4px 4px 0 0; background:rgba(135,35,35,.15); transition:height .6s; }
.fmockup-bar-item:nth-child(1) { height:40%; }
.fmockup-bar-item:nth-child(2) { height:60%; }
.fmockup-bar-item:nth-child(3) { height:45%; }
.fmockup-bar-item:nth-child(4) { height:80%; }
.fmockup-bar-item:nth-child(5) { height:55%; }
.fmockup-bar-item:nth-child(6) { height:90%; background:rgba(135,35,35,.5); }
.fmockup-bar-item:nth-child(7) { height:70%; }
.fmockup-list { flex:1; background:rgba(135,35,35,.03); border-radius:10px; padding:1rem; border:1px solid rgba(135,35,35,.06); }
html.dark .fmockup-list { background:rgba(135,35,35,.06); }
.fmockup-list__title { font-size:.7rem; font-weight:700; color:#6b7280; margin-bottom:.6rem; }
.fmockup-list-item { display:flex; align-items:center; gap:.4rem; padding:.3rem 0; border-bottom:1px solid rgba(0,0,0,.04); }
html.dark .fmockup-list-item { border-color:rgba(255,255,255,.03); }
.fmockup-list-item:last-child { border:none; }
.fmockup-list-dot { width:6px; height:6px; border-radius:50%; background:rgba(135,35,35,.4); flex-shrink:0; }
.fmockup-list-line { height:7px; border-radius:3.5px; background:rgba(135,35,35,.08); flex:1; }

/* ── Strip country code badge ── */
.fstrip__code {
    display:inline-flex; align-items:center; justify-content:center;
    width:22px; height:17px; border-radius:3px;
    background:rgba(135,35,35,.12); color:#872323;
    font-size:.58rem; font-weight:900; font-family:monospace;
    border:1px solid rgba(135,35,35,.18); flex-shrink:0;
}

/* ── Africa section overlay ── */
.fafrica__bg-overlay {
    position:absolute; inset:0;
    background:linear-gradient(135deg,rgba(10,2,4,.88) 0%,rgba(20,5,2,.82) 40%,rgba(8,14,4,.85) 100%);
}
.fafrica { position:relative; }

/* ── Africa city code badge ── */
.fafrica__city-code {
    flex-shrink:0; width:32px; height:24px; border-radius:5px;
    background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12);
    color:rgba(255,255,255,.8); font-size:.65rem; font-weight:900; font-family:monospace;
    display:flex; align-items:center; justify-content:center;
}
.fafrica__city-code--home {
    background:rgba(217,119,6,.3); border-color:rgba(217,119,6,.6); color:#fcd34d;
}
.fafrica__city--home { border-color:rgba(217,119,6,.35) !important; background:rgba(217,119,6,.06) !important; }
.fafrica__city-home-tag {
    display:inline-block; margin-left:.35rem;
    font-size:.58rem; font-weight:800; letter-spacing:.04em; text-transform:uppercase;
    background:rgba(217,119,6,.3); color:#fcd34d; padding:.05rem .35rem; border-radius:3px;
}

/* ─ RESPONSIVE MOBILE ─ */
@media(max-width:640px){
    .fafrica { padding:3.5rem 1rem; }
    .fafrica__stats { grid-template-columns:1fr 1fr; }
    .fafrica__cities { grid-template-columns:1fr; }
    .fmockup-strip { padding:1.5rem .75rem; }
    .fmockup-row { flex-direction:column; }
}

/* ── VARIABLES (dark only) ──────────────────────────────────── */
:root {
    --fr:       #872323;
    --frd:      #6b1c1c;
    --ease:     cubic-bezier(.16,1,.3,1);
    --bg-body:  #0c0c0f;
    --bg-white: #161619;
    --bg-off:   #111114;
    --text-1:   #f3f4f6;
    --text-2:   #d1d5db;
    --text-3:   #9ca3af;
    --text-4:   #6b7280;
    --border:   rgba(255,255,255,.07);
    --shadow-s: 0 2px 12px rgba(0,0,0,.4);
    --shadow-m: 0 8px 32px rgba(0,0,0,.5);
    --shadow-l: 0 20px 60px rgba(0,0,0,.65);
    --radius-s: 10px;
    --radius-m: 16px;
    --radius-l: 22px;
}

/* ── OVERRIDES DARK (sections transparentes, canvas visible) ─── */
.fhero { background: transparent; }
.fhero__bg { opacity: .35; }
.fstrip { background: rgba(255,255,255,.025); border-color: rgba(255,255,255,.06); }
.fsec { background: transparent; }
.fsec--off { background: rgba(255,255,255,.012); }
.fsec--tools { background: transparent; }
.fsec--stat-row { background: rgba(255,255,255,.015); }
.fsec--cta-wrap { background: transparent; }
.fwhy__card { background: rgba(22,22,25,.85); border-color: var(--border); backdrop-filter:blur(8px); }
.ftool { background: rgba(22,22,25,.85); border-color: var(--border); backdrop-filter:blur(8px); }
.ftool--active { background: rgba(26,14,14,.9); border-color: rgba(135,35,35,.3); }
.ftool__cta--disabled { background: rgba(31,41,55,.8); color: var(--text-4); }
.fstat-row { background: rgba(22,22,25,.85); border-color: var(--border); backdrop-filter:blur(8px); }
.fstats { background: rgba(22,22,25,.85); border-color: var(--border); backdrop-filter:blur(8px); }
.ftesti { background: rgba(22,22,25,.85); border-color: var(--border); backdrop-filter:blur(8px); }
.ftesti--feat { background: rgba(26,12,12,.9); border-color: rgba(135,35,35,.25); }
.fwhy__mockup { filter: drop-shadow(0 16px 40px rgba(135,35,35,.18)); }
html.dark .fstats { background: var(--bg-white); border-color: var(--border); }
html.dark .ftesti { background: var(--bg-white); border-color: var(--border); }
html.dark .ftesti--feat { background: linear-gradient(135deg, #1a0c0c, #161619); border-color: rgba(135,35,35,.2); }
html.dark .fcta--outline { background: var(--bg-white); color: var(--text-2); border-color: var(--border); }
html.dark .fcta--outline:hover { border-color: rgba(135,35,35,.4); color: var(--fr); }
html.dark .fring { border-color: rgba(135,35,35,.15); }
html.dark .fblob--top { background: radial-gradient(ellipse, rgba(135,35,35,.25) 0%, transparent 70%); }

/* ── BASE ────────────────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    background: transparent;    /* canvas global fournit le fond */
    color: var(--text-2);
    font-family: 'Inter', system-ui, sans-serif;
    -webkit-font-smoothing: antialiased;
}

/* ── REVEAL ANIMATIONS ──────────────────────────────────────── */
[data-reveal] {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity .75s var(--ease), transform .75s var(--ease);
}
[data-reveal].is-visible {
    opacity: 1;
    transform: translateY(0);
}
[data-reveal-delay="1"] { transition-delay: .12s }
[data-reveal-delay="2"] { transition-delay: .24s }
[data-reveal-delay="3"] { transition-delay: .36s }
[data-reveal-delay="4"] { transition-delay: .48s }

/* ══════════════════════════════════════════
   HERO
══════════════════════════════════════════ */
.fhero {
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 8rem 2rem 6rem;
    background: var(--bg-body);
    overflow: hidden;
}
.fhero__bg { position: absolute; inset: 0; overflow: hidden; z-index: 0; }
#smokeCanvas { position: absolute; inset: 0; width: 100%; height: 100%; pointer-events: none; }

.fring {
    position: absolute; border-radius: 50%;
    border: 1px solid rgba(135,35,35,.12);
    pointer-events: none; top: 50%; left: 50%;
}
.fring--1 { width: min(700px, 90vw); height: min(700px, 90vw); transform: translate(-50%,-50%); animation: ringPulse 9s ease-in-out infinite; }
.fring--2 { width: min(500px, 70vw); height: min(500px, 70vw); transform: translate(-50%,-50%); border-color: rgba(135,35,35,.08); animation: ringPulse 11s ease-in-out infinite 1.5s; }
.fring--3 { width: min(300px, 50vw); height: min(300px, 50vw); transform: translate(-50%,-50%); border-color: rgba(135,35,35,.06); animation: ringPulse 7s ease-in-out infinite 3s; }
@keyframes ringPulse {
    0%,100% { transform: translate(-50%,-50%) scale(1); opacity: .5 }
    50%      { transform: translate(-50%,-50%) scale(1.05); opacity: 1 }
}

.fblob {
    position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none;
}
.fblob--top {
    width: min(700px, 100vw); height: 300px;
    background: radial-gradient(ellipse, rgba(135,35,35,.18) 0%, transparent 70%);
    top: -80px; left: 50%; transform: translateX(-50%);
    animation: blobDrift 14s ease-in-out infinite;
}
.fblob--right {
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(135,35,35,.12) 0%, transparent 70%);
    bottom: 10%; right: -80px;
    animation: blobDrift 18s ease-in-out infinite reverse;
}
@keyframes blobDrift {
    0%,100% { transform: translateX(-50%) scale(1) translateY(0) }
    50%      { transform: translateX(-50%) scale(1.08) translateY(14px) }
}

.fhero__inner { position: relative; z-index: 1; max-width: 800px; margin: 0 auto; }

.fpill {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .35rem 1rem; border-radius: 100px;
    background: rgba(135,35,35,.06); border: 1px solid rgba(135,35,35,.18);
    font-size: .73rem; font-weight: 600; color: var(--fr); letter-spacing: .04em;
    margin-bottom: 1.75rem;
}
.fpill__dot { width: 6px; height: 6px; border-radius: 50%; background: var(--fr); box-shadow: 0 0 0 3px rgba(135,35,35,.18); animation: dotPulse 2s ease-in-out infinite; }
@keyframes dotPulse { 0%,100% { box-shadow: 0 0 0 3px rgba(135,35,35,.18) } 50% { box-shadow: 0 0 0 7px rgba(135,35,35,.05) } }

.fhero__h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(2.4rem, 6vw, 5rem); font-weight: 800;
    line-height: 1.07; letter-spacing: -.04em; color: var(--text-1);
    margin-bottom: 1.25rem;
}
.fhero__accent {
    background: linear-gradient(135deg, var(--fr) 0%, #c04040 60%, #e05555 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}

.fhero__sub {
    font-size: clamp(.92rem, 1.5vw, 1.08rem); color: var(--text-3);
    line-height: 1.78; max-width: 58ch; margin: 0 auto 2.25rem;
}

.fhero__ctas { display: flex; gap: .75rem; flex-wrap: wrap; justify-content: center; margin-bottom: 2.5rem; }

.fcta {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .78rem 1.55rem; border-radius: var(--radius-s);
    font-size: .88rem; font-weight: 700; text-decoration: none; cursor: pointer; border: none;
    transition: all .25s var(--ease); white-space: nowrap;
}
.fcta--primary {
    background: var(--fr); color: #fff; box-shadow: 0 4px 20px rgba(135,35,35,.28);
}
.fcta--primary:hover { background: var(--frd); transform: translateY(-2px); box-shadow: 0 10px 32px rgba(135,35,35,.38); }
.fcta--primary svg { transition: transform .25s var(--ease) }
.fcta--primary:hover svg { transform: translateX(4px) }

.fcta--outline {
    background: var(--bg-white); color: var(--text-2);
    border: 1.5px solid var(--border); box-shadow: var(--shadow-s);
}
.fcta--outline:hover { border-color: rgba(135,35,35,.3); color: var(--fr); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(135,35,35,.1); }

.fcta--white {
    background: #fff; color: var(--fr); box-shadow: 0 4px 20px rgba(0,0,0,.15);
    font-size: .92rem; padding: .85rem 1.75rem;
}
.fcta--white:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,0,0,.2); }
.fcta--white svg { transition: transform .25s var(--ease) }
.fcta--white:hover svg { transform: translateX(4px) }

.fcta--ghost-light {
    background: transparent; border: 1.5px solid rgba(255,255,255,.25);
    color: rgba(255,255,255,.82); padding: .85rem 1.5rem; font-size: .92rem;
}
.fcta--ghost-light:hover { border-color: rgba(255,255,255,.55); color: #fff; background: rgba(255,255,255,.08); }

.fstats {
    display: flex; align-items: center; gap: 1.5rem;
    padding: .9rem 1.75rem; border-radius: var(--radius-m);
    background: var(--bg-white); border: 1px solid var(--border); box-shadow: var(--shadow-m);
    width: fit-content; margin: 0 auto; flex-wrap: wrap; justify-content: center;
}
.fstat { text-align: center; }
.fstat__n { display: block; font-family: 'Space Grotesk', sans-serif; font-size: 1.65rem; font-weight: 800; color: var(--fr); line-height: 1; margin-bottom: .2rem; }
.fstat__l { font-size: .68rem; color: var(--text-4); font-weight: 500; letter-spacing: .03em; }
.fstat__sep { width: 1px; height: 32px; background: var(--border); flex-shrink: 0; }

.fscroll {
    position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%);
    z-index: 1; color: rgba(135,35,35,.35);
    animation: scrollBounce 2.2s ease-in-out infinite;
}
@keyframes scrollBounce {
    0%,100% { transform: translateX(-50%) translateY(0) }
    50%      { transform: translateX(-50%) translateY(7px) }
}

/* ── STRIP ──────────────────────────────── */
.fstrip {
    background: #fef4f4; border-top: 1px solid rgba(135,35,35,.07);
    border-bottom: 1px solid rgba(135,35,35,.07); padding: .95rem 0; overflow: hidden;
}
.fstrip__track { display: flex; align-items: center; gap: 1.25rem; max-width: 1200px; margin: 0 auto; padding: 0 2rem; flex-wrap: wrap; justify-content: center; }
.fstrip__item { display: inline-flex; align-items: center; gap: .45rem; font-size: .78rem; font-weight: 600; color: var(--fr); opacity: .8; transition: opacity .2s; }
.fstrip__item:hover { opacity: 1 }
.fstrip__sep { color: rgba(135,35,35,.25); font-size: .85rem; line-height: 1; }

/* ── SECTIONS COMMUNES ──────────────────── */
.fsec { padding: clamp(4rem, 8vw, 6.5rem) 0; background: var(--bg-white); }
.fsec--off      { background: var(--bg-off) }
.fsec--tools    { background: var(--bg-white); position: relative; overflow: hidden }
.fsec--stat-row { background: var(--bg-off); padding: 3.5rem 0 }
.fsec--cta-wrap { background: var(--bg-off); padding: clamp(3rem,6vw,5rem) 0 }
.fcont { max-width: 1200px; margin: 0 auto; padding: 0 clamp(1rem, 4vw, 2rem); }
.fsec__header { text-align: center; margin-bottom: 3.5rem; }
.feyebrow { display: inline-block; font-size: .7rem; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; color: var(--fr); margin-bottom: .65rem; }
.feyebrow--light { color: rgba(255,255,255,.55) }

.fsec__h2 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(1.85rem, 4vw, 3rem); font-weight: 800; line-height: 1.12;
    letter-spacing: -.035em; color: var(--text-1); margin-bottom: .75rem;
}
.facc { background: linear-gradient(135deg, var(--fr), #c04040); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.fsec__sub { font-size: .98rem; color: var(--text-3); max-width: 52ch; margin: 0 auto; line-height: 1.72; }

/* ── WHY ─────────────────────────────────── */
.fwhy { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: start; }
.fwhy__left .feyebrow { margin-bottom: .85rem }
.fwhy__left .fsec__h2 { text-align: left; margin-bottom: 0 }
.fwhy__mockup { margin-top: 2.5rem; max-width: 280px; filter: drop-shadow(0 16px 40px rgba(135,35,35,.12)); animation: floatUpDown 4s ease-in-out infinite; }
.fwhy__mockup svg { width: 100%; height: auto }
@keyframes floatUpDown { 0%,100% { transform: translateY(0) } 50% { transform: translateY(-12px) } }

.fwhy__p { font-size: .98rem; color: var(--text-3); line-height: 1.8; margin-bottom: 2rem; }
.fwhy__cards { display: flex; flex-direction: column; gap: .85rem; }
.fwhy__card {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: 1.1rem 1.25rem; background: var(--bg-white);
    border: 1px solid var(--border); border-radius: var(--radius-m);
    box-shadow: var(--shadow-s);
    transition: transform .3s var(--ease), box-shadow .3s var(--ease), border-color .3s;
}
.fwhy__card:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(135,35,35,.1); border-color: rgba(135,35,35,.2); }
.fwhy__card-icon { flex-shrink: 0; width: 40px; height: 40px; border-radius: 10px; background: rgba(135,35,35,.07); color: var(--fr); display: flex; align-items: center; justify-content: center; }
.fwhy__card-title { font-size: .88rem; font-weight: 700; color: var(--text-1); margin-bottom: .2rem; }
.fwhy__card-desc { font-size: .8rem; color: var(--text-3); line-height: 1.55; }

/* ── TOOLS DECO ─────────────────────────── */
.ftools__bg { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.ftools__circles {
    position: absolute; right: -100px; top: 50%; transform: translateY(-50%);
    width: 600px; height: 600px; opacity: .6; animation: slowRotate 60s linear infinite;
}
@keyframes slowRotate { from { transform: translateY(-50%) rotate(0deg) } to { transform: translateY(-50%) rotate(360deg) } }
.ftools__wave { position: absolute; bottom: 0; left: 0; width: 100%; height: 180px; }

/* ── TOOLS GRID ─────────────────────────── */
.ftools__grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; position: relative; z-index: 1; }

.ftool {
    position: relative; border-radius: var(--radius-l); padding: 2rem;
    border: 1px solid var(--border); background: var(--bg-white);
    box-shadow: var(--shadow-s); transition: transform .35s var(--ease), box-shadow .35s var(--ease);
    display: flex; flex-direction: column; overflow: hidden;
}
.ftool:hover { transform: translateY(-6px); box-shadow: var(--shadow-l); }
.ftool--active {
    border-color: rgba(135,35,35,.22); box-shadow: 0 8px 40px rgba(135,35,35,.12);
    background: linear-gradient(160deg, #fff 60%, #fff5f5 100%);
}
.ftool--active:hover { box-shadow: 0 20px 60px rgba(135,35,35,.18); }
.ftool--soon { opacity: .72; background: #fafafa; }
.ftool--soon:hover { opacity: .88 }

.ftool__top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
.ftool__icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: linear-gradient(135deg, var(--fr), #c04040);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(135,35,35,.3);
}
.ftool__icon--dim { background: #e5e7eb; box-shadow: none; color: #9ca3af; }

.ftool__live {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .7rem; font-weight: 700; color: #16a34a;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    padding: .25rem .7rem; border-radius: 100px; letter-spacing: .03em;
}
.ftool__live-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; animation: livePulse 2s ease-in-out infinite; }
@keyframes livePulse { 0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,.4) } 50% { box-shadow: 0 0 0 5px rgba(34,197,94,0) } }

.ftool__soon-badge {
    display: inline-flex; align-items: center; font-size: .7rem; font-weight: 700;
    color: #92400e; background: #fef3c7; border: 1px solid #fde68a;
    padding: .25rem .7rem; border-radius: 100px; letter-spacing: .03em;
}

.ftool__tag {
    display: inline-flex; align-items: center; gap: .35rem;
    font-size: .68rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
    color: var(--fr); background: rgba(135,35,35,.07); border: 1px solid rgba(135,35,35,.14);
    padding: .22rem .65rem; border-radius: 100px; margin-bottom: .85rem; width: fit-content;
}
.ftool__tag--dim { color: var(--text-4); background: #f3f4f6; border-color: #e5e7eb; }

.ftool__name { font-family: 'Space Grotesk', sans-serif; font-size: 1.22rem; font-weight: 800; color: var(--text-1); letter-spacing: -.025em; margin-bottom: .6rem; }
.ftool__name--dim { color: var(--text-3) }

.ftool__desc { font-size: .85rem; color: var(--text-3); line-height: 1.68; margin-bottom: 1.25rem; flex-grow: 1; }
.ftool__desc--dim { color: var(--text-4) }

.ftool__list { list-style: none; display: flex; flex-direction: column; gap: .55rem; margin-bottom: 1.5rem; }
.ftool__list li { display: flex; align-items: center; gap: .5rem; font-size: .8rem; font-weight: 500; color: var(--text-2); }
.ftool__list li svg { color: var(--fr); flex-shrink: 0 }
.ftool__list--dim li { color: var(--text-4) }
.ftool__list--dim li svg { color: var(--text-4) }

.ftool__cta {
    display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
    width: 100%; padding: .75rem 1.25rem; border-radius: var(--radius-s);
    font-size: .85rem; font-weight: 700; text-decoration: none; cursor: pointer; border: none;
    background: var(--fr); color: #fff; box-shadow: 0 4px 16px rgba(135,35,35,.25);
    transition: all .25s var(--ease); margin-top: auto;
}
.ftool__cta:hover { background: var(--frd); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(135,35,35,.35); }
.ftool__cta svg { transition: transform .25s var(--ease) }
.ftool__cta:hover svg { transform: translateX(4px) }

.ftool__cta--disabled { background: #f3f4f6; color: var(--text-4); box-shadow: none; cursor: not-allowed; }
.ftool__cta--disabled:hover { transform: none; box-shadow: none; background: #f3f4f6; }

.ftool__deco { position: absolute; bottom: 0; right: 0; width: 80px; height: 80px; pointer-events: none; overflow: hidden; }
.ftool__deco-line { position: absolute; background: rgba(135,35,35,.07); border-radius: 2px; }
.ftool__deco-line:nth-child(1) { width: 60px; height: 1px; bottom: 25px; right: -10px; transform: rotate(-45deg) }
.ftool__deco-line:nth-child(2) { width: 40px; height: 1px; bottom: 15px; right: -5px;  transform: rotate(-45deg) }
.ftool__deco-line:nth-child(3) { width: 80px; height: 1px; bottom: 35px; right: -20px; transform: rotate(-45deg) }
.ftool__deco-dot { position: absolute; width: 6px; height: 6px; border-radius: 50%; background: rgba(135,35,35,.2); bottom: 18px; right: 18px; }

/* ── STATS ROW ──────────────────────────── */
.fstat-row {
    display: grid; grid-template-columns: 1fr auto 1fr auto 1fr auto 1fr;
    align-items: center; border: 1px solid var(--border); border-radius: var(--radius-l);
    overflow: hidden; background: var(--bg-white); box-shadow: var(--shadow-s);
}
.fstat-big { padding: 2.25rem 1.5rem; text-align: center; transition: background .3s; }
.fstat-big:hover { background: rgba(135,35,35,.03) }
.fstat-big__n {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(1.75rem, 3.5vw, 2.6rem); font-weight: 800; color: var(--fr);
    line-height: 1; margin-bottom: .35rem; letter-spacing: -.04em;
}
.fstat-big__l { font-size: .73rem; color: var(--text-4); font-weight: 500; text-transform: uppercase; }
.fstat-row__sep { width: 1px; height: 60px; background: var(--border); flex-shrink: 0; }

/* ── TESTIMONIALS ───────────────────────── */
.ftesti-grid { display: grid; grid-template-columns: 1fr 1.18fr 1fr; gap: 1.25rem; align-items: start; }
.ftesti {
    background: var(--bg-white); border: 1px solid var(--border); border-radius: var(--radius-l);
    padding: 1.5rem; box-shadow: var(--shadow-s);
    transition: transform .3s var(--ease), box-shadow .3s; position: relative;
}
.ftesti:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,0,0,.09); }
.ftesti--feat {
    border-color: rgba(135,35,35,.18); box-shadow: 0 10px 40px rgba(135,35,35,.1);
    padding: 2.25rem 2rem;
}
.ftesti--feat:hover { box-shadow: 0 24px 60px rgba(135,35,35,.15); }
.ftesti__bigquote { position: absolute; top: 1rem; right: 1.5rem; font-size: 5.5rem; line-height: 1; color: rgba(135,35,35,.06); font-family: Georgia, serif; font-weight: 700; pointer-events: none; user-select: none; }
.ftesti__stars { display: flex; gap: 2px; margin-bottom: .85rem; }
.ftesti__text { font-size: .87rem; color: var(--text-2); line-height: 1.72; margin-bottom: 1.25rem; font-style: italic; }
.ftesti__who { display: flex; align-items: center; gap: .75rem; }
.ftesti__av { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .88rem; font-weight: 800; color: #fff; flex-shrink: 0; }
.ftesti__name { font-size: .83rem; font-weight: 700; color: var(--text-1); margin-bottom: .1rem; }
.ftesti__role { font-size: .71rem; color: var(--text-4); }

/* ── CTA CARD ────────────────────────────── */
.fcta-card {
    position: relative; border-radius: var(--radius-l);
    background: linear-gradient(135deg, var(--fr) 0%, #b03030 50%, #8c1a1a 100%);
    padding: clamp(3rem, 6vw, 5rem) clamp(2rem, 5vw, 4.5rem);
    overflow: hidden; text-align: center; box-shadow: 0 24px 70px rgba(135,35,35,.3);
}
.fcta-card__deco {
    position: absolute; inset: 0; pointer-events: none;
    display: flex; align-items: center; justify-content: center; overflow: hidden;
}
.fcta-card__deco svg {
    width: min(600px, 100%); height: min(600px, 100%);
    opacity: .35; animation: ctaSlowRotate 80s linear infinite;
}
@keyframes ctaSlowRotate { from { transform: rotate(0deg) } to { transform: rotate(360deg) } }
.fcta-card__glow {
    position: absolute; bottom: -80px; left: 50%; transform: translateX(-50%);
    width: 500px; height: 200px;
    background: radial-gradient(ellipse, rgba(255,255,255,.12) 0%, transparent 70%);
    pointer-events: none; filter: blur(20px);
}
.fcta-card__inner { position: relative; z-index: 1; }
.fcta-card__title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(2rem, 4vw, 3.2rem); font-weight: 800; color: #fff;
    letter-spacing: -.04em; line-height: 1.1; margin-bottom: .85rem;
}
.fcta-card__sub {
    font-size: clamp(.9rem, 1.5vw, 1.05rem); color: rgba(255,255,255,.72);
    line-height: 1.72; max-width: 50ch; margin: 0 auto 2.25rem;
}
.fcta-card__actions { display: flex; gap: .85rem; flex-wrap: wrap; justify-content: center; }

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .fwhy { grid-template-columns: 1fr; gap: 3rem; }
    .fwhy__left .fsec__h2 { text-align: left }
    .fwhy__mockup { max-width: 220px }
    .ftools__grid { grid-template-columns: 1fr; max-width: 520px; margin: 0 auto; }
    .ftesti-grid { grid-template-columns: 1fr; }
    .ftesti--feat { order: -1 }
    .fstat-row {
        grid-template-columns: 1fr auto 1fr !important;
        grid-template-rows: auto auto;
    }
    .fstat-row__sep:nth-child(6) { display: none }
    .fstat-row > .fstat-big:nth-child(7), .fstat-row > .fstat-big:nth-child(8) {
        grid-column: span 1;
    }
}

@media (max-width: 768px) {
    .fhero { padding: clamp(5rem, 12vw, 7rem) 1.5rem 5rem; min-height: auto; }
    .fpill { font-size: .7rem; }
    .fhero__h1 { font-size: clamp(2rem, 7vw, 2.8rem); }
    .fstrip__track { gap: .5rem 1.25rem; justify-content: center; }
    .fstrip__sep { display: none; }
    .fstrip__item { font-size: .7rem; }
    .fstat-row {
        /* 2 colonnes sur mobile */
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto;
    }
    .fstat-row .fstat-row__sep { display: none; }
    .fstat-big {
        padding: 1.5rem 1rem;
        border-bottom: 1px solid var(--border);
    }
    .fstat-big:nth-child(odd) { border-right: 1px solid var(--border); }
    .fstat-big:nth-child(3), .fstat-big:nth-child(4) { border-bottom: none; }
    .ftesti { padding: 1.25rem; }
    .ftesti--feat { padding: 1.5rem; }
    .fcta-card { padding: 2.5rem 1.5rem; }
    .fcta-card__actions { flex-direction: column; align-items: center; }
    .fcta--white, .fcta--ghost-light { width: 100%; justify-content: center; }
    .fwhy__mockup { max-width: 180px; margin-top: 1.5rem; }
}

@media (max-width: 480px) {
    .fhero { padding-top: 4.5rem; }
    .fhero__inner { padding: 0 .5rem; }
    .fhero__ctas { gap: .5rem; }
    .fcta { width: 100%; justify-content: center; }
    .fstats { gap: .5rem; padding: .75rem 1rem; flex-wrap: wrap; }
    .fstat__n { font-size: 1.3rem; }
    .fstat__sep { display: none; }
    .fwhy__mockup { display: none; }
    .fsec { padding: 3rem 0; }
    .fring, .fblob { opacity: .5; }
    .ftesti__stars { gap: 1px; }
    .ftesti__text { font-size: .8rem; }
    .fstat-row { grid-template-columns: 1fr; }
    .fstat-big { border-right: none !important; border-bottom: 1px solid var(--border); }
    .fstat-big:last-child { border-bottom: none; }
}

/* ── PAGINATION (non utilisé ici mais conservé) ── */
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* Scroll reveal */
    const revealObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                revealObs.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });
    document.querySelectorAll('[data-reveal]').forEach(el => revealObs.observe(el));

    /* Canvas spiral */
    const canvas = document.getElementById('smokeCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let W, H, raf;

    const resize = () => {
        W = canvas.width  = canvas.offsetWidth  || window.innerWidth;
        H = canvas.height = canvas.offsetHeight || window.innerHeight;
    };
    resize();
    window.addEventListener('resize', resize);

    function drawFrame() {
        ctx.clearRect(0, 0, W, H);
        const cx = W / 2, cy = H / 2;
        const t = Date.now() * 0.00032;

        for (let arm = 0; arm < 3; arm++) {
            ctx.beginPath();
            for (let i = 0; i < 450; i++) {
                const angle  = 0.052 * i + t + (arm * Math.PI * 2 / 3);
                const radius = 0.52 * i;
                if (radius > Math.min(W, H) * 0.55) break;
                const x = cx + radius * Math.cos(angle);
                const y = cy + radius * Math.sin(angle) * 0.44;
                if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
            }
            ctx.strokeStyle = `rgba(135,35,35,${0.08 + arm * 0.02})`;
            ctx.lineWidth = 1;
            ctx.stroke();
        }

        for (let i = 0; i < 12; i++) {
            const a = (i / 12) * Math.PI * 2 + t * 0.75;
            const r = 150 + Math.sin(t * 1.6 + i * 0.65) * 45;
            const x = cx + r * Math.cos(a);
            const y = cy + r * Math.sin(a) * 0.44;
            ctx.beginPath(); ctx.arc(x, y, 1.8 + Math.sin(t + i) * 0.8, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(135,35,35,0.28)';
            ctx.fill();
        }

        for (let i = 0; i < 6; i++) {
            const a = (i / 6) * Math.PI * 2 - t * 0.4;
            const r = 250 + Math.cos(t + i * 1.2) * 20;
            const x = cx + r * Math.cos(a);
            const y = cy + r * Math.sin(a) * 0.4;
            ctx.beginPath(); ctx.arc(x, y, 2.5, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(135,35,35,0.14)';
            ctx.fill();
        }

        raf = requestAnimationFrame(drawFrame);
    }
    drawFrame();
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) cancelAnimationFrame(raf); else drawFrame();
    });

    /* Count-up */
    const counted = new Set();
    const countObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting || counted.has(e.target)) return;
            counted.add(e.target);
            const target = parseInt(e.target.dataset.count) || 0;
            if (!target) return;
            const start = Date.now(), dur = 2000;
            const tick = () => {
                const p = Math.min((Date.now() - start) / dur, 1);
                const eased = 1 - Math.pow(1 - p, 3);
                e.target.textContent = Math.round(eased * target).toLocaleString('fr-FR');
                if (p < 1) requestAnimationFrame(tick);
            };
            tick();
        });
    }, { threshold: 0.25 });
    document.querySelectorAll('[data-count]').forEach(el => countObs.observe(el));
});
</script>
@endpush