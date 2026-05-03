<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Carbon;

class JobListing extends Model
{
    use HasUuids;

    protected $fillable = [
        'source', 'fingerprint', 'title', 'company', 'url',
        'description', 'tags', 'country', 'contract_type',
        'salary_min', 'salary_max', 'domain', 'remote',
        'scraped_at', 'expires_at',
    ];

    protected $casts = [
        'tags'       => 'array',
        'remote'     => 'boolean',
        'scraped_at' => 'datetime',
        'expires_at' => 'datetime',
        'salary_min' => 'integer',
        'salary_max' => 'integer',
    ];

    /**
     * Génère le fingerprint de déduplication inter-sources.
     */
    public static function makeFingerprint(string $title, string $company, string $url): string
    {
        $normalized = implode('|', [
            strtolower(preg_replace('/\s+/', '', strip_tags($title))),
            strtolower(preg_replace('/\s+/', '', strip_tags($company))),
            preg_replace('/[?#].*$/', '', strtolower(trim($url))), // strip query string
        ]);

        return md5($normalized);
    }

    /**
     * Récupère les offres non expirées.
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Récupère les offres jamais envoyées à un abonné donné.
     */
    public function scopeNotSentTo($query, string $subscriberId)
    {
        return $query->whereNotIn('id', function ($sub) use ($subscriberId) {
            $sub->select('job_listing_id')
                ->from('sent_job_logs')
                ->where('subscriber_id', $subscriberId);
        });
    }

    /**
     * Offres expirées (pour la purge).
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * Relation avec les logs d'envoi.
     */
    public function sentLogs()
    {
        return $this->hasMany(SentJobLog::class);
    }

    /**
     * Résumé court de la description (2 lignes).
     */
    public function getShortDescriptionAttribute(): string
    {
        if (!$this->description) return '';
        $text = strip_tags($this->description);
        $text = preg_replace('/\s+/', ' ', $text);
        return mb_substr($text, 0, 220) . (mb_strlen($text) > 220 ? '…' : '');
    }

    /**
     * Label lisible du type de contrat.
     */
    public function getContractLabelAttribute(): string
    {
        return match ($this->contract_type) {
            'full_time'  => 'CDI / Full-time',
            'part_time'  => 'Temps partiel',
            'freelance'  => 'Freelance',
            'contract'   => 'Contrat / CDD',
            'internship' => 'Stage',
            default      => $this->contract_type ?? 'Non précisé',
        };
    }
}
