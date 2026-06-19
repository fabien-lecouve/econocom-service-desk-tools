<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'code' => 'work_note',
                'label' => 'work note',
            ],
            [
                'code' => 'comment',
                'label' => 'commentaire utilisateur',
            ],
            [
                'code' => 'escalation',
                'label' => 'message d\'escalade',
            ],
        ];

        foreach ($types as $type) {
            DB::table('message_types')->updateOrInsert(
                ['code' => $type['code']],
                ['label' => $type['label']]
            );
        }
    }
}
