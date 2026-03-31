<?php
// app/Models/PositioningGeneration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PositioningGeneration extends Model
{
    use HasUuids;

    protected $fillable = [
        'ip_address', 'user_agent',
        'metier', 'techno', 'niveau', 'cible', 'resultat',
        'approche', 'extra', 'usages', 'ton', 'longueur',
        'phrase_1', 'phrase_2', 'phrase_3', 'phrase_retenue',
        'tip_linkedin', 'tip_portfolio', 'tip_freelance', 'tip_candidature',
    ];

    protected $casts = [
        'longueur' => 'integer',
    ];
}
