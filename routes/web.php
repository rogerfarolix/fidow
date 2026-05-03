<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\PositionnementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\LlmController;
use App\Http\Controllers\DigestController;

// Public
Route::get('/',          [AccueilController::class, 'index'])->name('home');
Route::get('/stats',     [StatsController::class, 'index'])->name('stats');
Route::get('/positionnement', [PositionnementController::class, 'index'])->name('positionnement');
Route::post('/generer',  [PositionnementController::class, 'generer'])->middleware('throttle:5,1')->name('generer');
Route::patch('/generation/{id}/retenir', [PositionnementController::class, 'retenirPhrase'])->name('generation.retenir');

// Pages légales
Route::get('/politique-de-confidentialite', function () {
    return view('legal.privacy');
})->name('privacy');

Route::get('/conditions-d-utilisation', function () {
    return view('legal.terms');
})->name('terms');

// Avis (Public)
Route::get('/avis',        [AvisController::class, 'index'])->name('avis.index');
Route::get('/avis/create', [AvisController::class, 'create'])->name('avis.create');
Route::post('/avis',       [AvisController::class, 'store'])->middleware('throttle:3,1')->name('avis.store');

// Login générique (pour compatibilité Laravel)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ── RemoteDigest ──────────────────────────────────────────────────────────────
Route::get('/remote-digest', [DigestController::class, 'index'])->name('digest.index');
Route::post('/remote-digest/subscribe', [DigestController::class, 'subscribe'])
     ->middleware('throttle:5,5')
     ->name('digest.subscribe');
Route::get('/remote-digest/unsubscribe/{token}', [DigestController::class, 'unsubscribe'])
     ->name('digest.unsubscribe');
Route::get('/remote-digest/preferences/{token}', [DigestController::class, 'preferences'])
     ->name('digest.preferences');
Route::post('/remote-digest/preferences/{token}', [DigestController::class, 'updatePreferences'])
     ->name('digest.preferences.update');



// Admin
Route::get('/admin/login',  [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->middleware('throttle:5,1')->name('admin.login.post');
Route::post('/admin/logout',[AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',   [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/data',        [AdminController::class, 'data'])->name('data');
    Route::get('/data/{id}',   [AdminController::class, 'show'])->name('show');
    
    // Gestion des avis
    Route::get('/avis',        [AvisController::class, 'adminIndex'])->name('avis.index');
    Route::patch('/avis/{avis}/approve', [AvisController::class, 'approve'])->name('avis.approve');
    Route::delete('/avis/{avis}/reject', [AvisController::class, 'reject'])->name('avis.reject');
    
    // Gestion des LLM
    Route::get('/llm',         [LlmController::class, 'index'])->name('llm.index');
    Route::get('/llm/{provider}', [LlmController::class, 'show'])->name('llm.show');
    Route::put('/llm/{provider}', [LlmController::class, 'update'])->name('llm.update');
    Route::post('/llm/{provider}/set-primary', [LlmController::class, 'setPrimary'])->name('llm.set-primary');
    Route::post('/llm/update-order', [LlmController::class, 'updateOrder'])->name('llm.update-order');
    Route::post('/llm/{provider}/toggle', [LlmController::class, 'toggleStatus'])->name('llm.toggle');
    Route::post('/llm/{provider}/test', [LlmController::class, 'testProvider'])->name('llm.test');
    Route::post('/llm/test-all', [LlmController::class, 'testAllConnections'])->name('llm.test-all');
    Route::post('/llm/{provider}/reset-stats', [LlmController::class, 'resetStats'])->name('llm.reset-stats');
    
    // APIs LLM
    Route::get('/llm/api/stats', [LlmController::class, 'apiStats'])->name('llm.api.stats');
    Route::post('/llm/api/test/{provider}', [LlmController::class, 'apiTestProvider'])->name('llm.api.test');
});
