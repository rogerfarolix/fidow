<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('llm_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->unique(); // groq, deepseek, mistral, google_ai, cloudflare, cerebras
            $table->string('display_name'); // Nom affiché dans le dashboard
            $table->string('model'); // Modèle utilisé
            $table->string('api_url'); // URL de l'API
            $table->boolean('is_active')->default(true); // Service activé ou non
            $table->integer('priority_order')->default(999); // Ordre de fallback (1 = premier)
            $table->json('settings')->nullable(); // Configuration spécifique (temperature, max_tokens, etc.)
            $table->integer('max_tokens')->default(1024);
            $table->float('temperature')->default(0.7);
            $table->integer('timeout_seconds')->default(30);
            $table->boolean('is_primary')->default(false); // Provider principal
            $table->timestamp('last_used_at')->nullable();
            $table->integer('usage_count')->default(0);
            $table->integer('success_count')->default(0);
            $table->integer('failure_count')->default(0);
            $table->text('last_error')->nullable();
            $table->timestamp('last_error_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'priority_order']);
            $table->index('is_primary');
            $table->index('provider');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llm_configurations');
    }
};
