<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Supprimer les contraintes étrangères si elles existent
        Schema::table('avis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // Supprimer la table existante
        Schema::dropIfExists('avis');

        // Recréer la table avec UUID comme clé primaire
        Schema::create('avis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom');
            $table->string('email');
            $table->integer('note')->between(1, 5);
            $table->text('commentaire');
            $table->enum('statut', ['pending', 'approved'])->default('pending');
            $table->foreignUuid('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
        
        // Recréer la table avec l'ancienne structure (bigint)
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email');
            $table->integer('note')->between(1, 5);
            $table->text('commentaire');
            $table->enum('statut', ['pending', 'approved'])->default('pending');
            $table->foreignUuid('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }
};
