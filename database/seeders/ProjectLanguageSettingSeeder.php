<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectLanguageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = DB::table('projects')->pluck('id', 'label');
        $languages = DB::table('languages')->pluck('id', 'code');

        $settings = [
            'urgo' => [
                'fr' => [
                    'signature' => 'SOS URGO FR',
                ],
                'en' => [
                    'signature' => 'SOS URGO EN',
                ],
            ],
        ];

        foreach ($settings as $projectLabel => $languagesSettings) {
            if (! isset($projects[$projectLabel])) {
                continue;
            }

            foreach ($languagesSettings as $langCode => $values) {
                if (! isset($languages[$langCode])) {
                    continue;
                }

                DB::table('project_language_settings')->updateOrInsert(
                    [
                        'project_id' => $projects[$projectLabel],
                        'language_id' => $languages[$langCode],
                    ],
                    [
                        'signature' => $values['signature']
                    ]
                );
            }
        }
    }
}
