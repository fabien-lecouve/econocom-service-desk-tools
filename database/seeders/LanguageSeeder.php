<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $languages = [
            [
                'code' => 'fr',
                'label' => 'français',
            ],
            [
                'code' => 'en',
                'label' => 'english',
            ]
        ];

        foreach ($languages as $language) {
            DB::table('languages')->updateOrInsert(
                ['code' => $language['code']],
                ['label' => $language['label']]
            );
        }
    }
}
