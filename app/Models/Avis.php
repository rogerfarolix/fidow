<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Avis extends Model
{
    use HasUuids;

    protected $fillable = [
        'nom',
        'email',
        'note',
        'commentaire',
        'statut',
        'user_id',
    ];

    protected $casts = [
        'note' => 'integer',
        'statut' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('statut', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('statut', 'pending');
    }
}
