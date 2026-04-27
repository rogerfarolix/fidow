@extends('layouts.app')

@section('title', 'Générations - Administration Fidow')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Admin -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 sm:py-0 sm:h-16 gap-3">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Générations de positionnement</h1>
                    <span class="self-start px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                        Administration
                    </span>
                </div>
                <div class="flex items-center space-x-3 self-end sm:self-auto">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                        ← Dashboard
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <!-- Stats Cards (inchangé) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ $generations->total() }}</div>
                    <div class="text-sm text-gray-600">Total générations</div>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ \App\Models\PositioningGeneration::whereNotNull('phrase_retenue')->count() }}</div>
                    <div class="text-sm text-gray-600">Phrases retenues</div>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ $allMetiers->count() }}</div>
                    <div class="text-sm text-gray-600">Métiers distincts</div>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A2.625 2.625 0 0018.75 10.5H8.25A2.625 2.625 0 006 13.255V15a2.625 2.625 0 002.25 2.625h10.5A2.625 2.625 0 0021 15v-1.745z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10.5c0 1.933-1.515 3.5-3.375 3.5S14.25 12.433 14.25 10.5 15.765 7 17.625 7 21 8.567 21 10.5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Toolbar (responsive) -->
        <form method="GET" action="{{ route('admin.data') }}" class="mb-6">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Rechercher par métier, cible, IP…"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                <select name="metier" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                    <option value="">Tous les métiers</option>
                    @foreach($allMetiers as $m)
                        <option value="{{ $m }}" @selected(request('metier') === $m)>{{ $m }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-red-700 text-white rounded-lg text-sm font-medium hover:bg-red-800 transition-colors">
                        Filtrer
                    </button>
                    <a href="{{ route('admin.data') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Results: Cards instead of table -->
        @if($generations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
                @foreach($generations as $g)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 flex flex-col hover:shadow-md transition-shadow">
                        <!-- Top row: ID + Date + IP -->
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <span class="font-mono">#{{ $g->id }}</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $g->created_at->format('d/m/Y H:i') }}
                            </span>
                            <span class="font-mono text-gray-400" title="IP">{{ $g->ip_address }}</span>
                        </div>

                        <!-- Métier & Cible -->
                        <div class="mb-3">
                            <div class="text-sm font-semibold text-gray-900 truncate" title="{{ $g->metier }}">
                                {{ $g->metier }}
                            </div>
                            <div class="text-xs text-gray-500 truncate mt-0.5" title="{{ $g->cible }}">
                                Cible : {{ Str::limit($g->cible, 40) }}
                            </div>
                        </div>

                        <!-- Phrase principale (clamped) -->
                        <div class="mb-3 flex-1">
                            <p class="text-sm text-gray-700 line-clamp-2" title="{{ $g->phrase_1 }}">
                                {{ $g->phrase_1 }}
                            </p>
                        </div>

                        <!-- Retenue badge + Action -->
                        <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                            <div>
                                @if($g->phrase_retenue)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Retenue
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        Aucune
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('admin.show', $g->id) }}" 
                               class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-700 transition-colors">
                                Voir détails
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3">
                {{ $generations->links() }}
            </div>
        @else
            <!-- Empty state -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Aucun résultat trouvé</h3>
                <p class="text-gray-500">Ajustez vos filtres ou réessayez plus tard.</p>
            </div>
        @endif
    </main>
</div>
@endsection