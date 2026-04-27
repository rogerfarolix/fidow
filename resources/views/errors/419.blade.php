@extends('layouts.app')

@section('title', 'Page expirée - Fidow')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="animate-on-scroll">
            <!-- Icone d'erreur -->
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-yellow-100 mb-6">
                <svg class="h-12 w-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-6xl font-bold text-gray-900 mb-4">419</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Page expirée</h2>
            
            <!-- Message -->
            <p class="text-gray-600 mb-8">
                Votre session a expiré pour des raisons de sécurité. Veuillez vous reconnecter pour continuer.
            </p>

            <!-- Actions -->
            <div class="space-y-4">
                <a href="{{ route('admin.login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Se reconnecter
                </a>
                
                <div class="text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-500 underline">
                        Retour à l'accueil
                    </a>
                </div>
            </div>

            <!-- Informations de sécurité -->
            <div class="mt-12 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800 mb-2">
                    <strong>🔐 Pourquoi cette page ?</strong>
                </p>
                <p class="text-xs text-blue-700">
                    Pour protéger votre sécurité, les sessions expirent automatiquement après une période d'inactivité.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
