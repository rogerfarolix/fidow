@extends('layouts.app')

@section('title', 'Configuration LLM - ' . $llmConfig->display_name)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0c0c0f]">

    {{-- Header --}}
    <header class="bg-white dark:bg-[#1a1a1d] border-b border-gray-200 dark:border-white/10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 sm:py-0 sm:h-16 gap-3">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $llmConfig->display_name }}</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700 dark:text-gray-200">Dashboard</a>
                            <span class="mx-1">›</span>
                            <a href="{{ route('admin.llm.index') }}" class="hover:text-gray-700 dark:text-gray-200">LLM</a>
                            <span class="mx-1">›</span>
                            {{ $llmConfig->display_name }}
                        </p>
                    </div>
                    <span class="self-start px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                        Administration
                    </span>
                </div>
                <div class="flex items-center space-x-3 self-end sm:self-auto">
                    <a href="{{ route('admin.llm.index') }}"
                       class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:text-gray-100 font-medium transition-colors">
                        ← LLM
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

        {{-- Status badges + Quick Actions --}}
        <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-4 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-2">
                    @if($llmConfig->is_primary)
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 rounded-full text-xs font-medium">Provider principal</span>
                    @endif
                    @if($llmConfig->is_active)
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 rounded-full text-xs font-medium">Actif</span>
                    @else
                        <span class="px-3 py-1 bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 rounded-full text-xs font-medium">Inactif</span>
                    @endif
                </div>
                <div class="flex flex-wrap gap-2">
                    <button onclick="testProvider()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Tester la connexion
                    </button>
@if(!$llmConfig->is_primary)
<button onclick="setPrimaryProvider('{{ $llmConfig->provider }}')"
        class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors inline-flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
    </svg>
    Définir comme principal
</button>
@endif

<button onclick="resetProviderStats('{{ $llmConfig->provider }}')"
        class="px-4 py-2 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-white/10 dark:bg-white/10 transition-colors inline-flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
    </svg>
    Réinitialiser stats
</button>
                </div>
            </div>
        </div>

        {{-- Configuration Form --}}
        <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden mb-6">
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-white/5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Configuration</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Paramètres du provider IA</p>
            </div>

            <form action="{{ route('admin.llm.update', $llmConfig->provider) }}" method="POST" class="p-4 sm:p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Left column --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Provider</label>
                            <input type="text" value="{{ $llmConfig->provider }}" readonly
                                   class="w-full px-3 py-2 border border-gray-200 dark:border-white/10 rounded-lg bg-gray-50 dark:bg-[#0c0c0f] text-gray-500 dark:text-gray-400 text-sm">
                        </div>
                        <div>
                            <label for="display_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nom affiché</label>
                            <input type="text" id="display_name" name="display_name" value="{{ $llmConfig->display_name }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-white/20 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        </div>
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Modèle</label>
                            <input type="text" id="model" name="model" value="{{ $llmConfig->model }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-white/20 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        </div>
                        <div>
                            <label for="api_url" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">URL API</label>
                            <input type="url" id="api_url" name="api_url" value="{{ $llmConfig->api_url }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-white/20 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        </div>
                    </div>

                    {{-- Right column --}}
                    <div class="space-y-4">
                        <div>
                            <label for="max_tokens" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Max Tokens</label>
                            <input type="number" id="max_tokens" name="max_tokens" value="{{ $llmConfig->max_tokens }}"
                                   min="1" max="8192"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-white/20 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        </div>
                        <div>
                            <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Température</label>
                            <input type="number" id="temperature" name="temperature" value="{{ $llmConfig->temperature }}"
                                   min="0" max="2" step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-white/20 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        </div>
                        <div>
                            <label for="timeout_seconds" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Timeout (secondes)</label>
                            <input type="number" id="timeout_seconds" name="timeout_seconds" value="{{ $llmConfig->timeout_seconds }}"
                                   min="5" max="120"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-white/20 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ $llmConfig->is_active ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-white/20 text-red-600 focus:ring-red-500">
                            <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-200">Provider actif</label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                    <a href="{{ route('admin.llm.index') }}"
                       class="px-4 py-2 bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-white/10 dark:bg-white/10 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-red-700 text-white rounded-lg text-sm font-medium hover:bg-red-800 transition-colors">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>

        {{-- Stats + API Status --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Usage Stats --}}
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5">
                <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-white/5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Statistiques d'utilisation</h3>
                </div>
                <div class="p-4 sm:p-6 space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Total utilisations</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $llmConfig->usage_count }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Succès</span>
                        <span class="font-medium text-green-600">{{ $llmConfig->success_count }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Échecs</span>
                        <span class="font-medium text-red-600">{{ $llmConfig->failure_count }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Taux de succès</span>
                        <span class="font-medium {{ $llmConfig->success_rate >= 90 ? 'text-green-600' : ($llmConfig->success_rate >= 70 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $llmConfig->success_rate }}%
                        </span>
                    </div>
                    @if($llmConfig->last_used_at)
                    <div class="pt-3 border-t border-gray-100 dark:border-white/5 text-sm text-gray-500 dark:text-gray-400">
                        Dernière utilisation : <span class="font-medium text-gray-700 dark:text-gray-200">{{ $llmConfig->last_used_at->diffForHumans() }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- API Status --}}
            <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5">
                <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-white/5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Statut API</h3>
                </div>
                <div class="p-4 sm:p-6 space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Clé API</span>
                        <span class="font-medium {{ $llmConfig->hasApiKey() ? 'text-green-600' : 'text-red-600' }}">
                            {{ $llmConfig->hasApiKey() ? '✓ Configurée' : '✗ Manquante' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Priorité</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">#{{ $llmConfig->priority_order }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-300">Statut</span>
                        <span class="font-medium {{ $llmConfig->is_active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ $llmConfig->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    @if($llmConfig->last_error)
                    <div class="pt-3 border-t border-gray-100 dark:border-white/5">
                        <span class="text-sm text-gray-600 dark:text-gray-300">Dernière erreur :</span>
                        <div class="mt-1 p-2 bg-red-50 dark:bg-red-900/20 rounded text-red-700 text-xs font-mono">
                            {{ Str::limit($llmConfig->last_error, 150) }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Test Result --}}
        <div class="bg-white dark:bg-[#1a1a1d] rounded-xl shadow-sm border border-gray-100 dark:border-white/5">
            <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-white/5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Test de connexion</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Vérifiez la disponibilité du provider en temps réel</p>
            </div>
            <div class="p-4 sm:p-6">
                <div id="test-result" class="text-sm text-gray-500 dark:text-gray-400">
                    Cliquez sur "Tester la connexion" pour vérifier le statut du provider.
                </div>
            </div>
        </div>

    </main>
</div>
@endsection

@push('scripts')
<script>
function getHeaders() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
    };
}

function testProvider() {
    const resultDiv = document.getElementById('test-result');
    resultDiv.innerHTML = '<span class="text-yellow-600">⏳ Test en cours…</span>';

    fetch(`/admin/llm/{{ $llmConfig->provider }}/test`, {   // ← /{provider}/test
        method: 'POST',                                       // ← POST
        headers: getHeaders()
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="p-3 bg-green-50 border border-green-100 rounded-lg text-green-700">
                        <div class="font-medium text-sm">✓ Connexion réussie</div>
                        <div class="text-xs mt-1">Provider : ${data.provider} — Modèle : ${data.model}</div>
                        <pre class="mt-2 bg-green-100 dark:bg-green-900/30 rounded p-2 text-xs overflow-auto">${JSON.stringify(data.data, null, 2)}</pre>
                    </div>`;
            } else {
                resultDiv.innerHTML = `
                    <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-100 rounded-lg text-red-700">
                        <div class="font-medium text-sm">✗ Échec de connexion</div>
                        <div class="text-xs mt-1">${data.error ?? 'Erreur inconnue'}</div>
                    </div>`;
            }
        })
        .catch(error => {
            resultDiv.innerHTML = `
                <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-100 rounded-lg text-red-700">
                    <div class="font-medium text-sm">✗ Erreur de test</div>
                    <div class="text-xs mt-1">${error.message}</div>
                </div>`;
        });
}

function setPrimaryProvider(provider) {
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

function resetProviderStats(provider) {
    if (!confirm('Réinitialiser toutes les statistiques de ce provider ?')) return;

    fetch(`/admin/llm/${provider}/reset-stats`, {   // ← /{provider}/reset-stats
        method: 'POST',
        headers: getHeaders()
    })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showNotification('Statistiques réinitialisées', 'success');
                setTimeout(() => location.reload(), 800);
            } else {
                showNotification('Erreur : ' + (data.message ?? 'Inconnue'), 'error');
            }
        })
        .catch(err => showNotification('Erreur : ' + err.message, 'error'));
}

function showNotification(message, type = 'info') {
    const n = document.createElement('div');
    n.className = `fixed top-4 right-4 px-4 py-3 rounded-lg text-white z-50 shadow-lg text-sm font-medium ${
        type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600'
    }`;
    n.textContent = message;
    document.body.appendChild(n);
    setTimeout(() => n.remove(), 3000);
}
</script>
@endpush