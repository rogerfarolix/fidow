<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class DigestSubscriber extends Model
{
    use HasUuids;

    protected $fillable = [
        'email', 'domain', 'metier', 'preferences',
        'send_hour', 'timezone', 'actif',
        'unsubscribe_token', 'confirmed_at',
    ];

    protected $casts = [
        'preferences'   => 'array',
        'actif'         => 'boolean',
        'send_hour'     => 'integer',
        'confirmed_at'  => 'datetime',
    ];

    protected $hidden = ['unsubscribe_token'];

    /**
     * Génère un token de désabonnement unique.
     */
    public static function generateUnsubscribeToken(): string
    {
        return (string) Str::uuid();
    }

    /**
     * Abonnés actifs seulement.
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Relation avec les offres envoyées.
     */
    public function sentJobs()
    {
        return $this->hasMany(SentJobLog::class, 'subscriber_id');
    }

    /**
     * Label du domaine.
     */
    public function getDomainLabelAttribute(): string
    {
        return match ($this->domain) {
            'dev'       => 'Développement',
            'design'    => 'Design / UX-UI',
            'marketing' => 'Marketing Digital',
            'cyber'     => 'Cybersécurité',
            'data'      => 'Data / IA',
            'product'   => 'Product Management',
            'other'     => 'Autre',
            default     => ucfirst($this->domain),
        };
    }

    /**
     * Préférences avec valeurs par défaut.
     */
    public function getPreferencesWithDefaultsAttribute(): array
    {
        return array_merge([
            'type_contrat' => null,
            'niveau'       => null,
            'pays'         => null,
            'langues'      => ['fr', 'en'],
            'salaire_min'  => null,
        ], $this->preferences ?? []);
    }
}
