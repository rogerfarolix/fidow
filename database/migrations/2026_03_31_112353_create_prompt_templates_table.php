<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prompt_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['profil', 'banniere']); // photo de profil ou bannière
            $table->string('titre', 120);
            $table->string('sous_titre', 200)->nullable();
            $table->text('description')->nullable();       // explication courte visible user
            $table->text('prompt_body');                   // le prompt complet avec placeholders {{variable}}
            $table->json('variables')->nullable();         // liste des champs à remplir ex: ["phrase","couleur1"]
            $table->string('image_path', 500)->nullable(); // preview/exemple du rendu
            $table->string('plateforme', 80)->nullable();  // ex: "LinkedIn, Facebook"
            $table->string('dimensions', 80)->nullable();  // ex: "1584×396 px"
            $table->unsignedTinyInteger('ordre')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prompt_templates');
    }
};
