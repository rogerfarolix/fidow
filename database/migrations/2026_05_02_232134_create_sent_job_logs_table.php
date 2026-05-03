<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sent_job_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('subscriber_id');
            $table->uuid('job_listing_id');
            $table->timestamp('sent_at')->useCurrent();

            // Contrainte absolue anti-doublon : une offre ne peut être envoyée
            // qu'une seule fois par abonné, garantie au niveau base de données.
            $table->unique(['subscriber_id', 'job_listing_id']);

            $table->foreign('subscriber_id')
                  ->references('id')
                  ->on('digest_subscribers')
                  ->onDelete('cascade');

            $table->foreign('job_listing_id')
                  ->references('id')
                  ->on('job_listings')
                  ->onDelete('cascade');

            $table->index('subscriber_id');
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sent_job_logs');
    }
};
