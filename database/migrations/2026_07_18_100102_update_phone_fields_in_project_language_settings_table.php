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
        Schema::table('project_language_settings', function (Blueprint $table) {
            $table->dropColumn('phone_override');

            $table->string('internal_phone_override')->nullable();
            $table->string('external_phone_override')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('project_language_settings', function (Blueprint $table) {
            $table->dropColumn([
                'internal_phone_override',
                'external_phone_override',
            ]);

            $table->text('phone_override')->nullable();
        });
    }
};
