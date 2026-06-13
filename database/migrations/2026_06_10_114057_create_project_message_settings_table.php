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
        Schema::create('project_message_settings', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('message_id')
                ->constrained()
                ->cascadeOnDelete();

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

            $table->integer('position')->default(0); 
                
            $table->char('shortcut', 1)->nullable();

            $table->timestamps();

            $table->unique(['message_id', 'project_id']);
            $table->unique(['project_id', 'shortcut']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_message_settings');
    }
};
