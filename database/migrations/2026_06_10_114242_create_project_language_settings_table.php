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
        Schema::create('project_language_settings', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('language_id')
                ->constrained()
                ->restrictOnDelete();

            $table->text('signature')->nullable();

            $table->timestamps();

            $table->unique(['project_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_language_settings');
    }
};
