@extends('layouts.app')

@section('title', 'Dashboard - Administration Fidow')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0c0c0f]">
    <!-- Header Admin -->
    <header class="bg-white dark:bg-[#1a1a1d] border-b border-gray-200 dark:border-white/10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('assets/logo.png') }}" alt="Fidow" class="h-8 w-auto">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Dashboard</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Administration Fidow</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">
                        Admin
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        {{ now()->format('d/m/Y H:i') }}
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-white/10 dark:bg-white/10 transition-colors">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Générations de positionnement -->
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">+12%</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                    {{ \App\Models\PositioningGeneration::count() }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Générations totales</div>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    {{ \App\Models\PositioningGeneration::where('created_at', '>=', now()->subDays(7))->count() }} cette semaine
                </div>
            </div>

            <!-- Avis en attente -->
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    @if(\App\Models\Avis::pending()->count() > 0)
                        <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 rounded-full text-xs font-medium animate-pulse">
                            Nouveau
                        </span>
                    @endif
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                    {{ \App\Models\Avis::pending()->count() }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Avis en attente</div>
                <div class="mt-3">
                    @if(\App\Models\Avis::pending()->count() > 0)
                        <a href="{{ route('admin.avis.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                            Voir les avis →
                        </a>
                    @else
                        <span class="text-xs text-green-600 font-medium">Tout à jour ✓</span>
                    @endif
                </div>
            </div>

            <!-- Avis approuvés -->
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-green-500 font-medium">+5%</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                    {{ \App\Models\Avis::approved()->count() }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Avis publiés</div>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    Note moyenne: {{ number_format(\App\Models\Avis::approved()->avg('note') ?: 0, 1) }}/5
                </div>
            </div>

            <!-- Utilisateurs -->
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                    {{ \App\Models\User::count() }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Utilisateurs</div>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    {{ \App\Models\User::where('created_at', '>=', now()->subDays(30))->count() }} ce mois-ci
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Actions rapides</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.avis.index') }}" 
                   class="flex items-center space-x-3 p-4 bg-white dark:bg-[#1a1a1d] rounded-lg border border-gray-200 dark:border-white/10 hover:border-blue-300 dark:hover:border-blue-500/50 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-gray-100">Gérer les avis</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ \App\Models\Avis::pending()->count() }} en attente</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('admin.data') }}" 
                   class="flex items-center space-x-3 p-4 bg-white dark:bg-[#1a1a1d] rounded-lg border border-gray-200 dark:border-white/10 hover:border-blue-300 dark:hover:border-blue-500/50 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-gray-100">Voir les statistiques</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Générations de positionnement</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('admin.llm.index') }}" 
                   class="flex items-center space-x-3 p-4 bg-white dark:bg-[#1a1a1d] rounded-lg border border-gray-200 dark:border-white/10 hover:border-purple-300 dark:hover:border-purple-500/50 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-gray-100">Gérer les LLM</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Services IA et fallbacks</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('avis.index') }}" target="_blank"
                   class="flex items-center space-x-3 p-4 bg-white dark:bg-[#1a1a1d] rounded-lg border border-gray-200 dark:border-white/10 hover:border-blue-300 dark:hover:border-blue-500/50 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-gray-100">Voir le site public</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Page des avis</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Dernières générations -->
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5">
                <div class="p-6 border-b border-gray-100 dark:border-white/5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Dernières générations</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Phrases de positionnement récentes</p>
                </div>
                <div class="p-6">
                    @php
                        $recentGenerations = \App\Models\PositioningGeneration::latest()->take(5)->get();
                    @endphp
                    @if($recentGenerations->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentGenerations as $generation)
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                            {{ $generation->metier }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $generation->cible }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $generation->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Aucune génération récente</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Avis récents -->
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5">
                <div class="p-6 border-b border-gray-100 dark:border-white/5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Avis récents</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Derniers avis des utilisateurs</p>
                </div>
                <div class="p-6">
                    @php
                        $recentAvis = \App\Models\Avis::latest()->take(5)->get();
                    @endphp
                    @if($recentAvis->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentAvis as $avi)
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 @if($avi->statut == 'pending') bg-yellow-500 @else bg-green-500 @endif"></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                                {{ $avi->nom }}
                                            </div>
                                            <span class="px-2 py-0.5 text-xs rounded-full @if($avi->statut == 'pending') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 @else bg-green-100 dark:bg-green-900/30 text-green-700 @endif">
                                                {{ $avi->statut == 'pending' ? 'En attente' : 'Approuvé' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-1 mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $avi->note)
                                                    <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-3 h-3 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $avi->note }}/5)</span>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $avi->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Aucun avis récent</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
