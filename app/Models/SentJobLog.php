<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentJobLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['subscriber_id', 'job_listing_id', 'sent_at'];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function subscriber()
    {
        return $this->belongsTo(DigestSubscriber::class, 'subscriber_id');
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class, 'job_listing_id');
    }
}
