<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = DB::table('languages')
            ->whereIn('code', ['fr', 'en', 'sp'])
            ->pluck('id', 'code');

        $settings = [
            'fr' => [
                'salutation' => 'Bonjour',
                'closing' => 'Cordialement',
            ],
            'en' => [
                'salutation' => 'Hello',
                'closing' => 'Best regards',
            ]
        ];

        foreach ($settings as $code => $values) {
            DB::table('language_settings')->updateOrInsert(
                ['language_id' => $languages[$code]],
                $values
            );
        }
    }
}
