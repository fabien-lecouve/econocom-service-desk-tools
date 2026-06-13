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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('font_color_id')
                ->nullable()
                ->constrained('colors')
                ->nullOnDelete();

            $table->foreignId('background_color_id')
                ->nullable()
                ->constrained('colors')
                ->nullOnDelete();

            $table->foreignId('border_top_color_id')
                ->nullable()
                ->constrained('colors')
                ->nullOnDelete();

            $table->string('slug', 100);
            $table->string('name', 100);

            $table->unsignedInteger('position')->default(0);

            $table->timestamps();

            $table->unique(['project_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
