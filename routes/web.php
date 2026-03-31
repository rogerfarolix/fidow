<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\PositionnementController;
use App\Http\Controllers\AdminController;

// Public
Route::get('/',          [AccueilController::class, 'index'])->name('home');
Route::get('/stats',     [StatsController::class, 'index'])->name('stats');
Route::get('/positionnement', [PositionnementController::class, 'index'])->name('positionnement');
Route::post('/generer',  [PositionnementController::class, 'generer'])->name('generer');
Route::patch('/generation/{id}/retenir', [PositionnementController::class, 'retenirPhrase'])->name('generation.retenir');
// ── OUTIL PHOTO DE PROFIL ─────────────────────────────────────────────────────
Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])
    ->name('profil');
Route::post('/profil/{id}/compiler', [App\Http\Controllers\ProfilController::class, 'compiler'])
    ->name('profil.compiler');

// ── OUTIL BANNIÈRE ────────────────────────────────────────────────────────────
Route::get('/banniere', [App\Http\Controllers\BanniereController::class, 'index'])
    ->name('banniere');
Route::post('/banniere/{id}/compiler', [App\Http\Controllers\BanniereController::class, 'compiler'])
    ->name('banniere.compiler');

// Admin
Route::get('/admin/login',  [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/data',        [AdminController::class, 'data'])->name('data');
    Route::get('/data/{id}',   [AdminController::class, 'show'])->name('show');
    Route::get('/admin/prompts', [App\Http\Controllers\AdminPromptController::class, 'index'])
        ->name('admin.prompts');
    Route::get('/admin/prompts/create', [App\Http\Controllers\AdminPromptController::class, 'create'])
        ->name('admin.prompts.create');
    Route::post('/admin/prompts', [App\Http\Controllers\AdminPromptController::class, 'store'])
        ->name('admin.prompts.store');
    Route::get('/admin/prompts/{id}/edit', [App\Http\Controllers\AdminPromptController::class, 'edit'])
        ->name('admin.prompts.edit');
    Route::put('/admin/prompts/{id}', [App\Http\Controllers\AdminPromptController::class, 'update'])
        ->name('admin.prompts.update');
    Route::delete('/admin/prompts/{id}', [App\Http\Controllers\AdminPromptController::class, 'destroy'])
        ->name('admin.prompts.destroy');
});
