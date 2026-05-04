<!DOCTYPE html>
<html lang="fr" class="scroll-smooth" x-data="themeApp()" :class="{ 'dark': darkMode }">
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
<body class="font-['Inter'] antialiased bg-gray-50 dark:bg-[#0c0c0f] text-gray-900 dark:text-gray-100" x-data="{ mobileMenu: false }">
    
    <!-- Background Pattern -->
    <div class="fixed inset-0 -z-10 opacity-30">
        <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-gray-50 dark:from-[#1a0505] dark:via-[#0c0c0f] dark:to-[#0f0f14]"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(135, 35, 35, 0.15) 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>

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
                                        <div class="font-medium text-gray-900 dark:text-gray-100 text-sm flex items-center gap-1.5">
                                            RemoteDigest
                                            <span style="font-size:.65rem;background:#872323;color:#fff;padding:.1rem .4rem;border-radius:4px;font-weight:800;">NEW</span>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">20 offres remote / jour, personnalisées</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Centre : Logo -->
                <div class="flex justify-center">
                    <a href="{{ route('home') }}" class="group">
                        <img
                            src="{{ asset('assets/logo.png') }}"
                            alt="Fidow Logo"
                            class="h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105 brightness-0 invert"
                        >
                    </a>
                </div>

                <!-- Droite : Avis + Stats + Dark Toggle + Commencer -->
                <div class="flex items-center justify-start space-x-1 pl-8">
                    <a href="{{ route('avis.index') }}"
                       class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm">
                        Avis
                    </a>
                    <a href="{{ route('stats') }}"
                       class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm">
                        Stats
                    </a>

                    <!-- Dark Mode Toggle -->
                    <button
                        @click="toggleDark()"
                        class="p-2 rounded-lg hover:bg-white/10 transition-all text-white/80 hover:text-white"
                        :title="darkMode ? 'Passer en mode clair' : 'Passer en mode sombre'"
                        aria-label="Toggle dark mode"
                    >
                        <!-- Sun icon (shown in dark mode) -->
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                        <!-- Moon icon (shown in light mode) -->
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>

                    <a href="#commencer"
                       class="ml-2 px-5 py-2 text-[#872323] bg-white rounded-lg font-semibold text-sm transition-all transform hover:scale-105 shadow-sm hover:bg-white/90">
                        Commencer
                    </a>
                </div>
            </div>

            <!-- Mobile : Logo gauche + burger droite -->
            <div class="flex md:hidden justify-between items-center h-16">
                <a href="{{ route('home') }}" class="group">
                    <img
                        src="{{ asset('assets/logo.png') }}"
                        alt="Fidow Logo"
                        class="h-9 w-auto object-contain transition-transform duration-200 group-hover:scale-105 brightness-0 invert"
                    >
                </a>
                <div class="flex items-center space-x-1">
                    <!-- Dark Mode Toggle Mobile -->
                    <button
                        @click="toggleDark()"
                        class="p-2 rounded-lg hover:bg-white/10 transition-colors text-white"
                        aria-label="Toggle dark mode"
                    >
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>
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
                        <a href="#"
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
                            <a href="{{ route('admin.login') }}" class="text-white/70 hover:text-white transition-colors inline-flex items-center space-x-1.5 justify-center sm:justify-start">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Connexion Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-white/70 hover:text-white transition-colors inline-flex items-center space-x-1.5 justify-center sm:justify-start">
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
                    <span>❤️</span>
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

    @stack('scripts')

    <!-- Dark Mode Alpine Component -->
    <script>
    function themeApp() {
        return {
            darkMode: localStorage.getItem('fidow-theme') === 'dark' ||
                      (!localStorage.getItem('fidow-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

            init() {
                // Apply immediately on init (before Alpine renders)
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                }
                // Watch system preference changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem('fidow-theme')) {
                        this.darkMode = e.matches;
                    }
                });
            },

            toggleDark() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('fidow-theme', this.darkMode ? 'dark' : 'light');
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }
    }

    // Apply dark mode BEFORE Alpine hydrates (prevents flash)
    (function() {
        const saved = localStorage.getItem('fidow-theme');
        if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    })();
    </script>
</body>
</html>
