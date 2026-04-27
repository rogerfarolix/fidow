@extends('layouts.app')

@section('title', 'Page non trouvée - Fidow')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="animate-on-scroll">
            <!-- Icone d'erreur -->
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 mb-6">
                <svg class="h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Page non trouvée</h2>
            
            <!-- Message -->
            <p class="text-gray-600 mb-8">
                Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
            </p>

            <!-- Actions -->
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Retour à l'accueil
                </a>
                
                <div class="text-sm text-gray-500">
                    Ou essayez de 
                    <button onclick="history.back()" class="text-blue-600 hover:text-blue-500 underline">
                        revenir en arrière
                    </button>
                </div>
            </div>

            <!-- Suggestions -->
            <div class="mt-12 p-4 bg-gray-100 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Peut-être cherchiez-vous :</p>
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="block text-sm text-blue-600 hover:text-blue-500">→ Page d'accueil</a>
                    <a href="{{ route('positionnement') }}" class="block text-sm text-blue-600 hover:text-blue-500">→ Générateur de positionnement</a>
                    <a href="{{ route('avis.index') }}" class="block text-sm text-blue-600 hover:text-blue-500">→ Avis des utilisateurs</a>
                    <a href="{{ route('stats') }}" class="block text-sm text-blue-600 hover:text-blue-500">→ Statistiques</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
