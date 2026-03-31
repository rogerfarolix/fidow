<?php
// app/Models/PromptTemplate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PromptTemplate extends Model
{
    use HasUuids;

    protected $fillable = [
        'type', 'titre', 'sous_titre', 'description',
        'prompt_body', 'variables', 'image_path',
        'plateforme', 'dimensions', 'ordre', 'actif',
    ];

    protected $casts = [
        'variables' => 'array',
        'actif'     => 'boolean',
        'ordre'     => 'integer',
    ];

    public function scopeActif($query)
    {
        return $query->where('actif', true)->orderBy('ordre');
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Remplace les placeholders {{variable}} dans le prompt_body
     * avec les valeurs fournies par l'utilisateur.
     */
    public function compilePrompt(array $values): string
    {
        $body = $this->prompt_body;
        foreach ($values as $key => $value) {
            $body = str_replace('{{' . $key . '}}', trim($value), $body);
        }
        return $body;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : null;
    }
}
