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
        Schema::create('project_category_color_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('font_color_id')
                ->constrained('colors')
                ->restrictOnDelete();

            $table->foreignId('background_color_id')
                ->constrained('colors')
                ->restrictOnDelete();

            $table->foreignId('border_top_color_id')
                ->nullable()
                ->constrained('colors')
                ->nullOnDelete();

            $table->timestamps();

            $table->softDeletes();

            $table->unique('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_category_color_settings');
    }
};
