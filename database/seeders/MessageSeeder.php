<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('id', 'slug');
        $types = DB::table('message_types')->pluck('id', 'code');
        $position = 1;

        $messages = [
            // Reminders (relances)
            [
                'category' => 'escalations',
                'type' => 'escalation',
                'slug' => 'escalation_1',
                'name' => 'escalade 1'
            ],
            [
                'category' => 'escalations',
                'type' => 'escalation',
                'slug' => 'escalation_2',
                'name' => 'escalade 2'
            ],
            [
                'category' => 'escalations',
                'type' => 'work_note',
                'slug' => 'closure',
                'name' => 'clôture'
            ],

            // Resolutions
            [
                'category' => 'resolution',
                'type' => 'comment',
                'slug' => 'incident_resolution',
                'name' => 'résolution incident'
            ],
            [
                'category' => 'resolution',
                'type' => 'comment',
                'slug' => 'request_resolution',
                'name' => 'résolution demande'
            ],
        ];

        foreach ($messages as $message) {
            DB::table('messages')->updateOrInsert(
                [
                    'project_id' => 1,
                    'slug' => $message['slug']
                ],
                [
                    'category_id' => $categories[$message['category']],
                    'message_type_id' => $types[$message['type']],
                    'font_color_id' => null,
                    'background_color_id' => null,
                    'border_top_color_id' => null,
                    'name' => $message['name'],
                    'position' => $position++
                ]
            );
        }
    }
}
