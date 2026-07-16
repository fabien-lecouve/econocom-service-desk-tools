<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Référentiels
            LanguageSeeder::class,
            MessageTypeSeeder::class,

            // Langues
            LanguageSettingSeeder::class,

            // Projets & utilisateurs
            // ProjectSeeder::class,

            // Langues par projet
            // ProjectLanguageSettingSeeder::class,

            // Catégories
            // CategorySeeder::class,

            // Messages
            // MessageSeeder::class,
            // MessageTranslationSeeder::class,
        ]);
    }
}
