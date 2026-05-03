<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('source', 60);              // 'remotive', 'weworkremotely', 'remoteok', etc.
            $table->string('fingerprint', 64)->unique(); // MD5 dédup inter-sources
            $table->string('title');
            $table->string('company')->nullable();
            $table->text('url')->unique();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();           // ['laravel', 'php', 'remote']
            $table->string('country', 80)->nullable();  // 'France', 'Worldwide', 'Africa', etc.
            $table->string('contract_type', 40)->nullable(); // 'full_time', 'freelance', 'part_time', 'contract'
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->string('domain', 80)->nullable();   // 'dev', 'design', 'marketing', 'cyber', 'data', etc.
            $table->boolean('remote')->default(true);
            $table->timestamp('scraped_at')->useCurrent();
            $table->timestamp('expires_at')->nullable(); // scraped_at + 14 jours
            $table->timestamps();

            $table->index('source');
            $table->index('domain');
            $table->index('expires_at');
            $table->index('scraped_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
