@extends('layouts.app')

@section('title', 'Service indisponible - Fidow')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="animate-on-scroll">
            <!-- Icone de maintenance -->
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-yellow-900/20 mb-6">
                <svg class="h-12 w-12 text-yellow-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-6xl font-bold text-gray-100 mb-4">503</h1>
            <h2 class="text-2xl font-semibold text-gray-200 mb-4">Service indisponible</h2>
            
            <!-- Message -->
            <p class="text-gray-400 mb-8">
                Nous effectuons actuellement une maintenance pour améliorer nos services. Nous serons bientôt de retour !
            </p>

            <!-- Timer de retour -->
            <div class="mb-8">
                <div class="inline-flex items-center px-4 py-2 bg-yellow-900/20 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-yellow-800 font-medium">Retour estimé dans <span id="countdown">--:--</span></span>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-4">
                <button onclick="location.reload()" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#872323] hover:bg-[#6b1c1c] focus:outline-none focus:ring-2  focus:ring-[#872323]/50 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Vérifier maintenant
                </button>
                
                <div class="text-sm text-gray-500 space-y-2">
                    <p class="font-medium">Pendant ce temps :</p>
                    <a href="{{ route('home') }}" class="block text-blue-400 hover:text-blue-500 underline">
                        → Consulter la page d'accueil
                    </a>
                    <a href="{{ route('stats') }}" class="block text-blue-400 hover:text-blue-500 underline">
                        → Voir les statistiques
                    </a>
                </div>
            </div>

            <!-- Informations de maintenance -->
            <div class="mt-12 p-4 border border-blue-900/30 bg-blue-900/10 rounded-lg">
                <p class="text-sm text-blue-300 mb-2">
                    <strong>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:.3rem"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                        En cours de maintenance
                    </strong>
                </p>
                <ul class="text-xs text-blue-400/80 text-left space-y-1">
                    <li>• Mise à jour des serveurs pour plus de performance</li>
                    <li>• Amélioration de la sécurité</li>
                    <li>• Ajout de nouvelles fonctionnalités</li>
                </ul>
                <p class="text-xs text-blue-400 mt-2">
                    Merci de votre patience et de votre compréhension.
                </p>
            </div>

            <!-- Notification optionnelle -->
            <div class="mt-6">
                <button onclick="notifyWhenReady()" class="text-sm text-blue-400 hover:text-blue-500 underline">
                    Me notifier quand le service est de retour
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Compte à rebours (simulé - à adapter avec le vrai temps)
let countdown = 300; // 5 minutes en secondes

function updateCountdown() {
    const minutes = Math.floor(countdown / 60);
    const seconds = countdown % 60;
    document.getElementById('countdown').textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    if (countdown > 0) {
        countdown--;
        setTimeout(updateCountdown, 1000);
    } else {
        document.getElementById('countdown').textContent = 'Bientôt !';
        // Auto-refresh quand le temps est écoulé
        setTimeout(() => location.reload(), 5000);
    }
}

// Auto-refresh toutes les 30 secondes
setInterval(() => {
    if (confirm('Voulez-vous vérifier si le service est de retour ?')) {
        location.reload();
    }
}, 30000);

// Notification (placeholder)
function notifyWhenReady() {
    if ('Notification' in window && Notification.permission === 'granted') {
        window.toast.show('Nous vous notifierons quand le service sera de retour !', 'info');
    } else {
        window.toast.show('Activez les notifications pour être alerté', 'info');
    }
}

// Démarrer le compte à rebours
updateCountdown();
</script>
@endsection
