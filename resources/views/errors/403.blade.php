@extends('layouts.app')

@section('title', 'Accès refusé - Fidow')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="animate-on-scroll">
            <!-- Icone d'erreur -->
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-orange-100 mb-6">
                <svg class="h-12 w-12 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-6xl font-bold text-gray-900 mb-4">403</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Accès refusé</h2>
            
            <!-- Message -->
            <p class="text-gray-600 mb-8">
                Vous n'avez pas les permissions nécessaires pour accéder à cette page.
            </p>

            <!-- Actions -->
            <div class="space-y-4">
                @if(auth()->check())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Tableau de bord
                    </a>
                @else
                    <a href="{{ route('admin.login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Se connecter
                    </a>
                @endif
                
                <div class="text-sm text-gray-500 space-y-2">
                    <a href="{{ route('home') }}" class="block text-blue-600 hover:text-blue-500 underline">
                        → Retour à l'accueil
                    </a>
                    <button onclick="history.back()" class="block text-blue-600 hover:text-blue-500 underline">
                        → Revenir en arrière
                    </button>
                </div>
            </div>

            <!-- Informations -->
            <div class="mt-12 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                <p class="text-sm text-orange-800 mb-2">
                    <strong>🚋 Pourquoi cet accès refusé ?</strong>
                </p>
                <ul class="text-xs text-orange-700 text-left space-y-1">
                    @if(!auth()->check())
                        <li>• Vous devez être connecté pour accéder à cette page</li>
                        <li>• Veuillez vous identifier avec vos crédits administrateur</li>
                    @else
                        <li>• Votre compte n'a pas les permissions nécessaires</li>
                        <li>• Contactez l'administrateur système si besoin</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
