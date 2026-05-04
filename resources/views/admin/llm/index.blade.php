@extends('layouts.app')

@section('title', 'Gestion des LLM - Administration Fidow')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0c0c0f]">

    {{-- Header --}}
    <header class="bg-white dark:bg-[#1a1a1d] border-b border-gray-200 dark:border-white/10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 sm:py-0 sm:h-16 gap-3">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Gestion des LLM</h1>
                    <span class="self-start px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                        Administration
                    </span>
                </div>
                <div class="flex items-center space-x-3 self-end sm:self-auto">
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:text-gray-100 font-medium transition-colors">
                        ← Dashboard
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-white/10 dark:bg-white/10 transition-colors">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl p-4 sm:p-6 shadow-sm border border-gray-100 dark:border-white/5 flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_usage'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">Utilisations totales</div>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl p-4 sm:p-6 shadow-sm border border-gray-100 dark:border-white/5 flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ count($stats['providers']) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">Providers configurés</div>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl p-4 sm:p-6 shadow-sm border border-gray-100 dark:border-white/5 flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-600">
                        {{ count(array_filter($stats['providers'], fn($p) => $p['is_active'])) }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">Providers actifs</div>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl p-4 sm:p-6 shadow-sm border border-gray-100 dark:border-white/5 flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-purple-600 truncate">
                        {{ $stats['primary_provider']['display_name'] ?? 'Non défini' }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">Provider principal</div>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Actions Bar --}}
        <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-4 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex flex-wrap gap-2">
                    <button onclick="testAllConnections()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Tester toutes les connexions
                    </button>
                    <button onclick="refreshStats()"
                            class="px-4 py-2 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-white/10 dark:bg-white/10 transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Actualiser
                    </button>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Ordre de fallback : <span id="fallback-order" class="font-medium text-gray-700 dark:text-gray-200"></span>
                </div>
            </div>
        </div>

        {{-- Providers List --}}
        <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden mb-6">
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-white/5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Providers configurés</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gérez et surveillez vos services IA</p>
            </div>

            <div id="providers-container" class="divide-y divide-gray-100">
                @foreach($stats['providers'] as $provider)
                <div class="p-4 sm:p-6 hover:bg-gray-50 dark:bg-[#0c0c0f] transition-colors" data-provider="{{ $provider['provider'] }}">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                        {{-- Provider Info --}}
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $provider['display_name'] }}</h3>
                                @if($provider['is_primary'])
                                    <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 rounded-full text-xs font-medium">Principal</span>
                                @endif
                                @if($provider['is_active'])
                                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 rounded-full text-xs font-medium">Actif</span>
                                @else
                                    <span class="px-2 py-0.5 bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 rounded-full text-xs font-medium">Inactif</span>
                                @endif
                                @if(!$provider['has_api_key'])
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">Clé manquante</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm mb-2">
                                <div><span class="text-gray-500 dark:text-gray-400">Modèle :</span> <span class="font-medium text-gray-800">{{ $provider['model'] }}</span></div>
                                <div><span class="text-gray-500 dark:text-gray-400">Priorité :</span> <span class="font-medium text-gray-800">#{{ $provider['priority_order'] }}</span></div>
                                <div><span class="text-gray-500 dark:text-gray-400">Utilisations :</span> <span class="font-medium text-gray-800">{{ $provider['usage_count'] }}</span></div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Succès :</span>
                                    <span class="font-medium {{ $provider['success_rate'] >= 90 ? 'text-green-600' : ($provider['success_rate'] >= 70 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $provider['success_rate'] }}%
                                    </span>
                                </div>
                            </div>

                            @if($provider['last_error'])
                            <div class="text-sm text-red-600 mt-1">
                                <span class="font-medium">Dernière erreur :</span> {{ Str::limit($provider['last_error'], 100) }}
                            </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-wrap gap-2">
                            <button onclick="testProvider('{{ $provider['provider'] }}')"
                                    class="px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 transition-colors">
                                Tester
                            </button>
                            <a href="{{ route('admin.llm.show', $provider['provider']) }}"
                               class="px-3 py-1.5 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-white/10 dark:bg-white/10 transition-colors">
                                Configurer
                            </a>
                            @if(!$provider['is_primary'])
                            <button onclick="setPrimary('{{ $provider['provider'] }}')"
                                    class="px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 rounded-lg text-sm font-medium hover:bg-purple-200 transition-colors">
                                Définir principal
                            </button>
                            @endif
                            <button onclick="toggleStatus('{{ $provider['provider'] }}', {{ $provider['is_active'] ? 'false' : 'true' }})"
                                    class="px-3 py-1.5 {{ $provider['is_active'] ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 dark:bg-green-900/30 text-green-700 hover:bg-green-200' }} rounded-lg text-sm font-medium transition-colors">
                                {{ $provider['is_active'] ? 'Désactiver' : 'Activer' }}
                            </button>
                        </div>
                    </div>

                    {{-- Connection Status --}}
                    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Statut :</span>
                            <span id="status-{{ $provider['provider'] }}" class="text-sm font-medium">
                                @if(isset($connections[$provider['provider']]))
                                    @if($connections[$provider['provider']]['available'])
                                        <span class="text-green-600">✓ Connecté</span>
                                    @else
                                        <span class="text-red-600">✗ {{ $connections[$provider['provider']]['error'] }}</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">Non testé</span>
                                @endif
                            </span>
                        </div>
                        @if($provider['last_used_at'])
                        <div class="text-xs text-gray-400">
                            Dernière utilisation : {{ $provider['last_used_at']->diffForHumans() }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Fallback Order --}}
        <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-4 sm:p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">Ordre de fallback</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Glissez-déposez les providers pour définir l'ordre de tentative en cas d'échec.
            </p>
            <div id="sortable-providers" class="space-y-2">
                @foreach(collect($stats['providers'])->sortBy('priority_order') as $provider)
                @if($provider['is_active'])
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-[#0c0c0f] rounded-lg cursor-move hover:bg-gray-100 dark:bg-white/5 transition-colors border border-gray-100 dark:border-white/5"
                     data-provider="{{ $provider['provider'] }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="font-medium text-gray-800">{{ $provider['display_name'] }}</span>
                        @if($provider['is_primary'])
                            <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 rounded-full text-xs font-medium">Principal</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">#{{ $provider['priority_order'] }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            <button onclick="saveOrder()"
                    class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                Enregistrer l'ordre
            </button>
        </div>

    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('sortable-providers');
    if (el) {
        new Sortable(el, {
            animation: 150,
            ghostClass: 'opacity-40',
            onEnd: updateFallbackOrder
        });
    }
    updateFallbackOrder();
});

// Helper centralisé pour les headers fetch (CSRF inclus)
function getHeaders() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
    };
}

function updateFallbackOrder() {
    const providers = document.querySelectorAll('#sortable-providers [data-provider]');
    const order = Array.from(providers).map(el => el.dataset.provider);
    const el = document.getElementById('fallback-order');
    if (el) el.textContent = order.join(' → ');
}

// REMPLACE ces fonctions dans le <script>

function testProvider(provider) {
    const statusEl = document.getElementById(`status-${provider}`);
    if (!statusEl) return;
    statusEl.innerHTML = '<span class="text-yellow-600">⏳ Test en cours…</span>';

    fetch(`/admin/llm/${provider}/test`, {   // ← /{provider}/test
        method: 'POST',                       // ← POST (pas GET)
        headers: getHeaders()
    })
        .then(r => r.json())
        .then(data => {
            statusEl.innerHTML = data.success
                ? '<span class="text-green-600">✓ Connecté</span>'
                : `<span class="text-red-600">✗ ${data.error ?? 'Erreur inconnue'}</span>`;
            showNotification(
                data.success ? 'Connexion réussie' : 'Échec : ' + (data.error ?? ''),
                data.success ? 'success' : 'error'
            );
        })
        .catch(err => {
            statusEl.innerHTML = '<span class="text-red-600">✗ Erreur de test</span>';
            showNotification('Erreur : ' + err.message, 'error');
        });
}

function testAllConnections() {
    showNotification('Tests en cours…', 'info');
    fetch('/admin/llm/test-all', {
        method: 'POST',                       // ← POST (pas GET)
        headers: getHeaders()
    })
        .then(r => r.json())
        .then(data => {
            Object.keys(data.connections).forEach(provider => {
                const el = document.getElementById(`status-${provider}`);
                if (!el) return;
                el.innerHTML = data.connections[provider].available
                    ? '<span class="text-green-600">✓ Connecté</span>'
                    : `<span class="text-red-600">✗ ${data.connections[provider].error ?? 'Erreur'}</span>`;
            });
            showNotification('Tests terminés', 'success');
        })
        .catch(err => showNotification('Erreur : ' + err.message, 'error'));
}

function setPrimary(provider) {
    if (!confirm(`Définir "${provider}" comme provider principal ?`)) return;

    fetch(`/admin/llm/${provider}/set-primary`, {   // ← /{provider}/set-primary
        method: 'POST',
        headers: getHeaders()
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showNotification('Provider principal mis à jour', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur : ' + (data.message ?? 'Inconnue'), 'error');
            }
        })
        .catch(err => showNotification('Erreur : ' + err.message, 'error'));
}

function toggleStatus(provider, isActive) {
    const label = isActive ? 'activer' : 'désactiver';
    if (!confirm(`Voulez-vous ${label} le provider "${provider}" ?`)) return;

    fetch(`/admin/llm/${provider}/toggle`, {   // ← /{provider}/toggle
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify({ is_active: isActive })
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message ?? 'Statut mis à jour', 'success');
                setTimeout(() => location.reload(), 800);
            } else {
                showNotification('Erreur : ' + (data.message ?? 'Inconnue'), 'error');
            }
        })
        .catch(err => showNotification('Erreur : ' + err.message, 'error'));
}

function saveOrder() {
    const providers = Array.from(
        document.querySelectorAll('#sortable-providers [data-provider]')
    ).map(el => el.dataset.provider);

    if (providers.length === 0) {
        showNotification('Aucun provider à ordonner', 'error');
        return;
    }

    fetch('/admin/llm/update-order', {
        method: 'POST',
        headers: getHeaders(),          // ← CSRF ajouté ici
        body: JSON.stringify({ providers })
    })
        .then(r => r.json())
        .then(data => showNotification(
            data.success ? 'Ordre mis à jour' : 'Erreur : ' + (data.message ?? 'Inconnue'),
            data.success ? 'success' : 'error'
        ))
        .catch(err => showNotification('Erreur : ' + err.message, 'error'));
}

function refreshStats() { location.reload(); }

function showNotification(message, type = 'info') {
    const n = document.createElement('div');
    n.className = `fixed top-4 right-4 px-4 py-3 rounded-lg text-white z-50 shadow-lg text-sm font-medium transition-opacity ${
        type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600'
    }`;
    n.textContent = message;
    document.body.appendChild(n);
    setTimeout(() => n.remove(), 3000);
}
</script>
@endpush