<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LlmConfiguration extends Model
{
    protected $fillable = [
        'provider',
        'display_name',
        'model',
        'api_url',
        'is_active',
        'priority_order',
        'settings',
        'max_tokens',
        'temperature',
        'timeout_seconds',
        'is_primary',
        'last_used_at',
        'usage_count',
        'success_count',
        'failure_count',
        'last_error',
        'last_error_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_primary' => 'boolean',
        'temperature' => 'float',
        'last_used_at' => 'datetime',
        'last_error_at' => 'datetime',
    ];

    /**
     * Scope pour obtenir les providers actifs triés par priorité
     */
    public function scopeActiveAndOrdered(Builder $query): Builder
    {
        return $query->where('is_active', true)
                    ->orderBy('priority_order', 'asc')
                    ->orderBy('id', 'asc');
    }

    /**
     * Scope pour obtenir le provider principal
     */
    public function scopePrimary(Builder $query): Builder
    {
        return $query->where('is_primary', true);
    }

    /**
     * Obtenir le provider principal actif
     */
    public static function getPrimary(): ?self
    {
        return static::activeAndOrdered()->primary()->first();
    }

    /**
     * Obtenir tous les providers actifs dans l'ordre de fallback
     */
    public static function getActiveProviders(): Builder
    {
        return static::activeAndOrdered();
    }

    /**
     * Mettre à jour les statistiques d'utilisation
     */
    public function recordUsage(bool $success = true, ?string $error = null): void
    {
        $this->increment('usage_count');
        
        if ($success) {
            $this->increment('success_count');
            $this->last_error = null;
            $this->last_error_at = null;
        } else {
            $this->increment('failure_count');
            $this->last_error = $error;
            $this->last_error_at = now();
        }
        
        $this->last_used_at = now();
        $this->save();
    }

    /**
     * Obtenir le taux de succès
     */
    public function getSuccessRateAttribute(): float
    {
        if ($this->usage_count === 0) {
            return 0;
        }
        
        return round(($this->success_count / $this->usage_count) * 100, 2);
    }

    /**
     * Définir comme provider principal (désactive les autres)
     */
    public function setAsPrimary(): void
    {
        // Désactiver tous les autres providers principaux
        static::where('is_primary', true)->update(['is_primary' => false]);
        
        // Activer celui-ci comme principal
        $this->update(['is_primary' => true]);
    }

public function getApiKey(): ?string
{
    return match($this->provider) {
        'groq'       => config('services.groq.key'),
        'mistral'    => config('services.mistral.api_key'),
        'google_ai'  => config('services.google_ai.api_key'),
        'cloudflare' => config('services.cloudflare.api_key'),
        'cerebras'   => config('services.cerebras.api_key'),
        default      => null,
    };
}

public function getCloudflareAccountId(): ?string
{
    return config('services.cloudflare.account_id');
}

public function hasApiKey(): bool
{
    return !empty($this->getApiKey());
}

/**
 * Google AI utilise la clé en query param (pas en Bearer header)
 */
public function getHttpHeaders(): array
{
    $headers = ['Content-Type' => 'application/json'];

    if ($this->provider !== 'google_ai') {
        $apiKey = $this->getApiKey();
        if ($apiKey) {
            $headers['Authorization'] = 'Bearer ' . $apiKey;
        }
    }

    return $headers;
}
}
