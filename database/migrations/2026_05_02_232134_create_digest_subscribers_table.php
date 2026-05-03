<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digest_subscribers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('domain', 80);               // 'dev', 'design', 'marketing', 'cyber', 'data', 'other'
            $table->string('metier');                   // 'Développeur Laravel', 'Pentester', etc.
            $table->json('preferences')->nullable();    // {type_contrat, niveau, pays, langues[], salaire_min}
            $table->unsignedSmallInteger('send_hour')->default(19); // 0-23
            $table->string('timezone', 60)->default('Africa/Porto-Novo');
            $table->boolean('actif')->default(true);
            $table->uuid('unsubscribe_token')->unique();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index('actif');
            $table->index('domain');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digest_subscribers');
    }
};
