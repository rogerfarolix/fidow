<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
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
<body class="bg-gray-50 text-gray-900 font-['Inter'] antialiased" x-data="{ mobileMenu: false }">
    
    <!-- Background Pattern -->
    <div class="fixed inset-0 -z-10 opacity-30">
        <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-gray-50"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(135, 35, 35, 0.15) 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>

    <!-- Header – même couleur que le footer -->
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
                        <div class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 translate-y-1 group-hover:translate-y-0">
                            <div class="p-2">
                                <a href="{{ route('positionnement') }}" class="flex items-start space-x-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="mt-0.5 w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: #87232315;">
                                        <svg class="w-4 h-4" style="color: #872323;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm">Positionnement Pro</div>
                                        <div class="text-xs text-gray-500 mt-0.5">Génère ta phrase de positionnement</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Centre : Logo (blanc grâce au filtre) -->
                <div class="flex justify-center">
                    <a href="{{ route('home') }}" class="group">
                        <img
                            src="{{ asset('assets/logo.png') }}"
                            alt="Fidow Logo"
                            class="h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105 brightness-0 invert"
                        >
                    </a>
                </div>

                <!-- Droite : Avis + Stats + Commencer -->
                <div class="flex items-center justify-start space-x-1 pl-8">
                    <a href="{{ route('avis.index') }}"
                       class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm">
                        Avis
                    </a>
                    <a href="{{ route('stats') }}"
                       class="px-4 py-2 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-all font-medium text-sm">
                        Stats
                    </a>
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
                <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-lg hover:bg-white/10 transition-colors text-white">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
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

    <!-- Footer – responsive amélioré -->
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

            <!-- Bottom Bar – responsive -->
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

    @stack('scripts')
</body>
</html>