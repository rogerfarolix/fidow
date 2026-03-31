<?php
// app/Models/ToolUsage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ToolUsage extends Model
{
    use HasUuids;

    protected $fillable = [
        'tool_slug',
        'ip_address',
        'user_agent',
    ];
}
