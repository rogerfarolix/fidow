<?php
// database/migrations/2024_01_01_000002_create_positioning_generations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positioning_generations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ip_address', 45)->index();
            $table->string('user_agent')->nullable();

            // Inputs
            $table->string('metier', 120);
            $table->string('techno', 300)->nullable();
            $table->string('niveau', 60)->nullable();
            $table->string('cible', 200);
            $table->text('resultat');
            $table->string('approche', 200)->nullable();
            $table->text('extra')->nullable();
            $table->string('usages', 300)->nullable();
            $table->string('ton', 80)->nullable();
            $table->tinyInteger('longueur')->default(2);

            // Outputs
            $table->text('phrase_1');
            $table->text('phrase_2');
            $table->text('phrase_3');
            $table->text('phrase_retenue')->nullable(); // celle que l'user a copiée/choisie
            $table->text('tip_linkedin')->nullable();
            $table->text('tip_portfolio')->nullable();
            $table->text('tip_freelance')->nullable();
            $table->text('tip_candidature')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positioning_generations');
    }
};
