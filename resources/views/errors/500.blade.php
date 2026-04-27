@extends('layouts.app')

@section('title', 'Erreur serveur - Fidow')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="animate-on-scroll">
            <!-- Icone d'erreur -->
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 mb-6">
                <svg class="h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-6xl font-bold text-gray-900 mb-4">500</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Erreur serveur</h2>
            
            <!-- Message -->
            <p class="text-gray-600 mb-8">
                Une erreur inattendue s'est produite. Nos équipes ont été notifiées et travaillent à résoudre le problème.
            </p>

            <!-- Actions -->
            <div class="space-y-4">
                <button onclick="location.reload()" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Réessayer
                </button>
                
                <div class="text-sm text-gray-500 space-y-2">
                    <a href="{{ route('home') }}" class="block text-blue-600 hover:text-blue-500 underline">
                        → Retour à l'accueil
                    </a>
                    <button onclick="history.back()" class="block text-blue-600 hover:text-blue-500 underline">
                        → Revenir en arrière
                    </button>
                </div>
            </div>

            <!-- Informations complémentaires -->
            <div class="mt-12 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800 mb-2">
                    <strong>Que faire ?</strong>
                </p>
                <ul class="text-xs text-yellow-700 text-left space-y-1">
                    <li>• Réessayez dans quelques instants</li>
                    <li>• Vérifiez votre connexion internet</li>
                    <li>• Contactez-nous si le problème persiste</li>
                </ul>
            </div>

            <!-- ID d'erreur pour le support -->
            @if(config('app.debug'))
            <div class="mt-8 p-3 bg-gray-800 text-green-400 rounded text-xs font-mono">
                Error ID: {{ uniqid() }}<br>
                Time: {{ now()->format('Y-m-d H:i:s') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Auto-refresh après 30 secondes
setTimeout(() => {
    if (confirm('Voulez-vous réessayer automatiquement ?')) {
        location.reload();
    }
}, 30000);
</script>
@endsection
