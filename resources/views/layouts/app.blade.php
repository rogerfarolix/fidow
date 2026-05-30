<!DOCTYPE html>
<html lang="fr" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fidow - Suite d\'outils pour Professionnels Remote')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
    
    @stack('styles')
</head>
<body class="font-['Inter'] antialiased bg-[#0a0a0d] text-gray-100" x-data="{ mobileMenu: false }">
    
    <!-- Scroll progress bar -->
    <div id="scroll-progress" role="progressbar" aria-hidden="true"></div>

    <!-- Canvas background animé — spirales · géométrie · réseau · binaire -->
    <canvas id="fidow-bg" aria-hidden="true"
            style="position:fixed;inset:0;width:100%;height:100%;z-index:-10;pointer-events:none;display:block;"></canvas>

    <!-- Header -->
    <header class="sticky top-0 z-50 bg-[#872323]/95 backdrop-blur-md border-b border-white/10 shadow-lg">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Desktop : 3 colonnes -->
            <div class="hidden md:grid grid-cols-3 items-center h-16">

                <!-- Gauche : Accueil + Outils -->
                <div class="flex items-center justify-end space-x-1 pr-8">
                    <a href="{{ route('home') }}"
                       class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm">
                        Accueil
                    </a>

                    <!-- Outils dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm flex items-center space-x-1">
                            <span>Outils</span>
                            <svg class="w-4 h-4 mt-0.5 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute top-full left-0 mt-2 w-64 bg-white dark:bg-[#1a1a1d] rounded-xl shadow-xl border border-gray-100 dark:border-white/10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 translate-y-1 group-hover:translate-y-0">
                            <div class="p-2">
                                <a href="{{ route('positionnement') }}" class="flex items-start space-x-3 px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <div class="mt-0.5 w-8 h-8 rounded-lg flex items-center justify-content flex-shrink-0" style="background-color: #87232315;">
                                        <svg class="w-4 h-4 mx-auto" style="color: #872323;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">Positionnement Pro</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Génère ta phrase de positionnement</div>
                                    </div>
                                </a>
                                <a href="{{ route('digest.index') }}" class="flex items-start space-x-3 px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <div class="mt-0.5 w-8 h-8 rounded-lg flex items-center justify-content flex-shrink-0" style="background-color: #87232315;">
                                        <svg class="w-4 h-4 mx-auto" style="color: #872323;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                                            RemoteDigest
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">20 offres remote / jour, personnalisées</div>
                                    </div>
                                </a>

                                <a href="{{ route('tjm.index') }}" class="flex items-start space-x-3 px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <div class="mt-0.5 w-8 h-8 rounded-lg flex items-center justify-content flex-shrink-0" style="background-color:#87232315;">
                                        <svg class="w-4 h-4 mx-auto" style="color:#872323;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">Simulateur TJM</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Calcule ton tarif freelance idéal</div>
                                    </div>
                                </a>

                                <a href="{{ route('linkedin.analyse') }}" class="flex items-start space-x-3 px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <div class="mt-0.5 w-8 h-8 rounded-lg flex items-center justify-content flex-shrink-0" style="background-color:rgba(10,102,194,.08);">
                                        <svg class="w-4 h-4 mx-auto" style="color:#0a66c2;" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100 text-sm flex items-center gap-1.5">
                                            Analyse LinkedIn
                                            <span style="font-size:.65rem;background:#0a66c2;color:#fff;padding:.1rem .4rem;border-radius:4px;font-weight:800;">IA</span>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Score + recommandations IA</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Centre : Logo -->
                <div class="flex justify-center">
                    <a href="{{ route('home') }}" class="group flex items-center space-x-2">
                        <img
                            src="{{ asset('assets/logo.png') }}"
                            alt="Fidow Logo"
                            class="h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105 brightness-0 invert"
                        >
                        <span class="text-white font-bold text-xl tracking-wide">FIDOW</span>
                    </a>
                </div>

                <!-- Droite : Avis + Stats + Docs + Dark Toggle + Commencer -->
                <div class="flex items-center justify-start space-x-1 pl-8">
                    <a href="{{ route('avis.index') }}"
                       class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm">
                        Avis
                    </a>
                    <a href="{{ route('stats') }}"
                       class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm">
                        Stats
                    </a>
                    <a href="{{ route('docs') }}"
                       class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm">
                        Docs
                    </a>

                    <a href="#commencer"
                       class="ml-2 px-5 py-2 text-[#872323] bg-white rounded-lg font-semibold text-sm transition-all transform hover:scale-105 shadow-sm hover:bg-white/90">
                        Commencer
                    </a>
                </div>
            </div>

            <!-- Mobile : Logo gauche + burger droite -->
            <div class="flex md:hidden justify-between items-center h-16">
                <a href="{{ route('home') }}" class="group flex items-center space-x-2">
                    <img
                        src="{{ asset('assets/logo.png') }}"
                        alt="Fidow Logo"
                        class="h-9 w-auto object-contain transition-transform duration-200 group-hover:scale-105 brightness-0 invert"
                    >
                    <span class="text-white font-bold text-lg tracking-wide">FIDOW</span>
                </a>
                <div class="flex items-center space-x-1">
                    <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-lg hover:bg-white/10 transition-colors text-white">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden border-t border-white/10 pb-4 pt-3">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2.5 text-white/80 hover:bg-white/10 hover:text-white rounded-lg transition-colors font-medium text-sm">Accueil</a>
                    <a href="{{ route('positionnement') }}" class="flex items-center px-4 py-2.5 text-white/80 hover:bg-white/10 hover:text-white rounded-lg transition-colors font-medium text-sm">Outils</a>
                    <a href="{{ route('avis.index') }}" class="flex items-center px-4 py-2.5 text-white/80 hover:bg-white/10 hover:text-white rounded-lg transition-colors font-medium text-sm">Avis</a>
                    <a href="{{ route('stats') }}" class="flex items-center px-4 py-2.5 text-white/80 hover:bg-white/10 hover:text-white rounded-lg transition-colors font-medium text-sm">Stats</a>
                    <div class="pt-2 px-4">
                        <a href="#commencer" class="block w-full px-4 py-2.5 bg-white text-[#872323] rounded-lg font-semibold text-sm text-center transition-all hover:bg-white/90">
                            Commencer
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background-color: #872323;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center sm:text-left">

                <!-- Brand -->
                <div class="col-span-1 sm:col-span-2 md:col-span-2">
                    <div class="mb-5 flex justify-center sm:justify-start">
                        <img
                            src="{{ asset('assets/logo.png') }}"
                            alt="Fidow Logo"
                            class="h-10 w-auto object-contain brightness-0 invert"
                        >
                    </div>
                    <p class="text-white/75 mb-6 max-w-md mx-auto sm:mx-0 leading-relaxed text-sm">
                        Suite d'outils gratuits pour aider les professionnels du remote à développer leur carrière du début jusqu'à l'expertise.
                    </p>
                    <div class="flex justify-center sm:justify-start">
                        <a href="{{ route('don') }}"
                           class="inline-flex items-center space-x-2 px-5 py-2.5 bg-white rounded-lg font-semibold text-sm transition-all hover:bg-white/90 hover:scale-105 shadow-md"
                           style="color: #872323;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span>Faire un don</span>
                        </a>
                    </div>
                </div>

                <!-- Navigation -->
                <div>
                    <h3 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Navigation</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="text-white/70 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="{{ route('positionnement') }}" class="text-white/70 hover:text-white transition-colors">Outils</a></li>
                        <li><a href="{{ route('avis.index') }}" class="text-white/70 hover:text-white transition-colors">Avis</a></li>
                        <li><a href="{{ route('stats') }}" class="text-white/70 hover:text-white transition-colors">Stats</a></li>
                        <li><a href="#commencer" class="text-white/70 hover:text-white transition-colors">Commencer</a></li>
                    </ul>
                </div>

                <!-- Admin & Légal -->
                <div>
                    <h3 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Administration</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li>
                            <a href="{{ route('docs') }}" class="text-white/70 hover:text-white transition-colors">Documentation</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.login') }}" class="text-white/70 hover:text-white transition-colors inline-flex items-center space-x-1.5 justify-center sm:justify-start">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Connexion Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('don') }}" class="text-white/70 hover:text-white transition-colors inline-flex items-center space-x-1.5 justify-center sm:justify-start">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>Faire un don</span>
                            </a>
                        </li>
                        <li><a href="{{ route('privacy') }}" class="text-white/70 hover:text-white transition-colors">Politique de confidentialité</a></li>
                        <li><a href="{{ route('terms') }}" class="text-white/70 hover:text-white transition-colors">Conditions d'utilisation</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t mt-8 md:mt-10 pt-6 md:pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-center md:text-left" style="border-color: rgba(255,255,255,0.2);">
                <p class="text-white/60 text-xs md:text-sm">&copy; {{ date('Y') }} Fidow. Tous droits réservés.</p>
                <p class="flex items-center space-x-1.5 text-white/60 text-xs md:text-sm">
                    <span>Réalisé avec</span>
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" style="color:rgba(255,255,255,.7)"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                    <span>par</span>
                    <a href="https://roger.nealix.org" target="_blank" rel="noopener noreferrer"
                       class="text-white font-semibold hover:underline transition-all">
                        Roger Gnanih
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Cookie Consent Modal -->
    <div x-data="{ showCookie: !localStorage.getItem('cookie_accepted') }" 
         x-show="showCookie" 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
         style="display: none;">
        
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"
             x-show="showCookie"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        <!-- Modal -->
        <div class="relative w-full max-w-md bg-white dark:bg-[#1a1a1d] rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-white/10"
             x-show="showCookie"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="p-6 sm:p-8">
                <!-- Icon -->
                <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-[#872323] dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    Respect de votre vie privée
                </h3>
                
                <div class="text-sm text-gray-600 dark:text-gray-300 space-y-4">
                    <p>
                        En poursuivant votre navigation sur Fidow, vous acceptez l'utilisation de cookies pour améliorer votre expérience utilisateur et nous permettre de réaliser des statistiques de visites.
                    </p>
                    <p>
                        Pour en savoir plus, consultez notre <a href="{{ route('privacy') }}" class="text-[#872323] dark:text-red-400 hover:underline font-medium">Politique de confidentialité</a>.
                    </p>
                </div>

                <div class="mt-8">
                    <button @click="localStorage.setItem('cookie_accepted', 'true'); showCookie = false;" 
                            class="w-full flex items-center justify-center px-6 py-3 bg-[#872323] text-white rounded-xl text-sm font-semibold hover:bg-red-800 transition-all hover:scale-[1.02] active:scale-[0.98] shadow-md">
                        Accepter et continuer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ════ FIDOW BACKGROUND — Canvas animé global ════
         Spirales · Réseau de particules · Pluie binaire · Géométrie
         Visible sur TOUTES les pages et TOUTES les sections. -->
    <script>
    (function () {
        const C = document.getElementById('fidow-bg');
        if (!C) return;
        const ctx = C.getContext('2d');

        /* ── Config ─────────────────────────────── */
        const CFG = {
            bg:          '#0a0a0d',
            red:         '135,35,35',
            white:       '255,255,255',
            particleN:   55,
            connDist:    130,
            colW:        28,
            gridSize:    64,
            fps:         30,           // Limite CPU
        };

        /* ── État ───────────────────────────────── */
        let W, H, frame = 0, angle = 0;
        let particles = [], columns = [], lastTime = 0;

        /* ── Resize ─────────────────────────────── */
        function resize() {
            W = C.width  = window.innerWidth;
            H = C.height = window.innerHeight;
            initColumns();
        }
        window.addEventListener('resize', resize, { passive: true });

        /* ── Init particules ────────────────────── */
        function initParticles() {
            particles = Array.from({ length: CFG.particleN }, () => ({
                x:  Math.random() * W,
                y:  Math.random() * H,
                vx: (Math.random() - .5) * .35,
                vy: (Math.random() - .5) * .35,
                r:  Math.random() * 1.6 + .4,
            }));
        }

        /* ── Init colonnes binaires ─────────────── */
        function initColumns() {
            const n = Math.ceil(W / CFG.colW) + 1;
            columns = Array.from({ length: n }, () => ({
                y:     Math.random() * H * -1,
                speed: Math.random() * .7 + .15,
            }));
        }

        /* ── Dessin grille ──────────────────────── */
        function drawGrid() {
            ctx.strokeStyle = `rgba(${CFG.white},0.025)`;
            ctx.lineWidth = 1;
            for (let x = 0; x <= W; x += CFG.gridSize) {
                ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, H); ctx.stroke();
            }
            for (let y = 0; y <= H; y += CFG.gridSize) {
                ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(W, y); ctx.stroke();
            }
            // Points pulsants aux croisements
            const pulse = Math.sin(frame * .025) * .5 + .5;
            ctx.fillStyle = `rgba(${CFG.red},${.12 * pulse})`;
            for (let x = 0; x <= W; x += CFG.gridSize * 3) {
                for (let y = 0; y <= H; y += CFG.gridSize * 3) {
                    const lp = Math.sin(frame * .025 + x * .001 + y * .001) * .5 + .5;
                    ctx.beginPath();
                    ctx.arc(x, y, 1.5 * lp + .5, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
        }

        /* ── Pluie de code binaire / math ──────── */
        const CHARS = '01φπ∑∞⌀∂∇{}[]<>/;#'.split('');
        function drawRain() {
            ctx.font = '10px "Fira Code",monospace';
            columns.forEach((col, i) => {
                const fade = Math.min(1, Math.abs(col.y) / (H * .5));
                ctx.fillStyle = `rgba(${CFG.red},${.055 * fade})`;
                ctx.fillText(CHARS[Math.floor(Math.random() * CHARS.length)], i * CFG.colW, col.y);
                col.y += col.speed;
                if (col.y > H + 20) col.y = Math.random() * -300;
            });
        }

        /* ── Réseau de particules ───────────────── */
        function drawNetwork() {
            particles.forEach(p => {
                p.x = (p.x + p.vx + W) % W;
                p.y = (p.y + p.vy + H) % H;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${CFG.red},.45)`;
                ctx.fill();
            });
            ctx.lineWidth = .5;
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const d  = Math.hypot(dx, dy);
                    if (d < CFG.connDist) {
                        ctx.strokeStyle = `rgba(${CFG.red},${(1 - d / CFG.connDist) * .14})`;
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                    }
                }
            }
        }

        /* ── Spirales ───────────────────────────── */
        function drawSpiral(cx, cy, maxR, turns, dir, a, alpha) {
            ctx.beginPath();
            const steps = turns * Math.PI;
            for (let t = 0; t <= steps; t += .06) {
                const r = (maxR / steps) * t;
                const x = cx + r * Math.cos(dir * t + a);
                const y = cy + r * Math.sin(dir * t + a);
                t === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            }
            ctx.strokeStyle = `rgba(${CFG.red},${alpha})`;
            ctx.lineWidth = 1;
            ctx.stroke();
        }
        function drawSpirals() {
            const base = Math.min(W, H);
            drawSpiral(W * .78, H * .22, base * .22, 7, 1,  angle,        .09);
            drawSpiral(W * .18, H * .78, base * .16, 5, -1, angle * .65,  .07);
        }

        /* ── Géométrie tournante ────────────────── */
        const GEO = [
            { sides:3, xr:.15, yr:.3,  r:90,  speed:.0009, phase:0 },
            { sides:6, xr:.5,  yr:.12, r:55,  speed:-.0006,phase:1 },
            { sides:4, xr:.85, yr:.72, r:70,  speed:.0007, phase:2 },
            { sides:3, xr:.65, yr:.88, r:50,  speed:-.0010,phase:3 },
            { sides:5, xr:.92, yr:.35, r:44,  speed:.0008, phase:4 },
            { sides:8, xr:.32, yr:.58, r:38,  speed:-.0005,phase:5 },
        ];
        function drawGeometry() {
            ctx.lineWidth = 1;
            GEO.forEach(g => {
                const a = angle * 300 * g.speed + g.phase;
                ctx.beginPath();
                for (let i = 0; i <= g.sides; i++) {
                    const ang = a + (i * 2 * Math.PI) / g.sides;
                    const x = g.xr * W + g.r * Math.cos(ang);
                    const y = g.yr * H + g.r * Math.sin(ang);
                    i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
                }
                ctx.closePath();
                ctx.strokeStyle = `rgba(${CFG.red},.09)`;
                ctx.stroke();
                // Inner concentric
                ctx.beginPath();
                for (let i = 0; i <= g.sides; i++) {
                    const ang = -a + (i * 2 * Math.PI) / g.sides;
                    const x = g.xr * W + g.r * .5 * Math.cos(ang);
                    const y = g.yr * H + g.r * .5 * Math.sin(ang);
                    i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
                }
                ctx.closePath();
                ctx.strokeStyle = `rgba(${CFG.red},.05)`;
                ctx.stroke();
            });
        }

        /* ── Courbe de Lissajous ────────────────── */
        function drawLissajous() {
            const cx = W * .5, cy = H * .5;
            const rx = Math.min(W, H) * .08, ry = rx;
            const a = 3, b = 2, delta = angle * .4;
            ctx.beginPath();
            for (let t = 0; t <= 2 * Math.PI; t += .03) {
                const x = cx + rx * Math.sin(a * t + delta);
                const y = cy + ry * Math.sin(b * t);
                t === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
            }
            ctx.strokeStyle = `rgba(${CFG.red},.1)`;
            ctx.lineWidth = 1.2;
            ctx.stroke();
        }

        /* ── Boucle principale ──────────────────── */
        const interval = 1000 / CFG.fps;
        function loop(ts) {
            requestAnimationFrame(loop);
            if (ts - lastTime < interval) return;
            lastTime = ts;

            ctx.fillStyle = CFG.bg;
            ctx.fillRect(0, 0, W, H);

            drawGrid();
            drawRain();
            drawNetwork();
            drawSpirals();
            drawGeometry();
            drawLissajous();

            angle += .003;
            frame++;
        }

        /* ── Démarrage ──────────────────────────── */
        resize();
        initParticles();
        requestAnimationFrame(loop);
    })();
    </script>

    @stack('scripts')

    <!-- Global: scroll-progress + data-reveal + page animations -->
    <script>
    // Scroll progress bar
    (function() {
        const bar = document.getElementById('scroll-progress');
        if (!bar) return;
        window.addEventListener('scroll', function() {
            const pct = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight);
            bar.style.transform = 'scaleX(' + Math.min(pct, 1) + ')';
        }, { passive: true });
    })();

    // Intersection Observer for data-reveal
    (function() {
        const els = document.querySelectorAll('[data-reveal]');
        if (!els.length) return;
        const io = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.08 });
        els.forEach(function(el) { io.observe(el); });
    })();
    </script>

</body>
</html>
