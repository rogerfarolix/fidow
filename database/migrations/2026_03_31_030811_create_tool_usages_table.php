<?php
// database/migrations/2024_01_01_000001_create_tool_usages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tool_usages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tool_slug', 60)->index();   // 'positionnement', 'cv-builder', etc.
            $table->string('ip_address', 45)->index();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tool_usages');
    }
};
