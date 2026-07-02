<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('id', 'code');
        $types = DB::table('message_types')->pluck('id', 'code');
        $position = 1;

        $messages = [
            // Reminders (relances)
            [
                'category' => 'escalations',
                'type' => 'escalation',
                'code' => 'escalation_1',
                'label' => 'escalade 1'
            ],
            [
                'category' => 'escalations',
                'type' => 'escalation',
                'code' => 'escalation_2',
                'label' => 'escalade 2'
            ],
            [
                'category' => 'escalations',
                'type' => 'work_note',
                'code' => 'closure',
                'label' => 'clôture'
            ],

            // Resolutions
            [
                'category' => 'resolution',
                'type' => 'comment',
                'code' => 'incident_resolution',
                'label' => 'résolution incident'
            ],
            [
                'category' => 'resolution',
                'type' => 'comment',
                'code' => 'request_resolution',
                'label' => 'résolution demande'
            ],
        ];

        foreach ($messages as $message) {
            DB::table('messages')->updateOrInsert(
                [
                    'project_id' => 1,
                    'code' => $message['code']
                ],
                [
                    'category_id' => $categories[$message['category']],
                    'message_type_id' => $types[$message['type']],
                    'font_color_id' => null,
                    'background_color_id' => null,
                    'border_top_color_id' => null,
                    'label' => $message['label'],
                    'position' => $position++
                ]
            );
        }
    }
}
