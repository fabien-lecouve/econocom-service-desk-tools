<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = DB::table('languages')->pluck('id', 'code');
        $messages = DB::table('messages')->pluck('id', 'code');

        $translations = [
            'escalation_1' => [
                'fr' => [
                    'content' => 'Relance concernant votre demande.',
                ],
                'en' => [
                    'content' => 'escalation regarding your request.',
                ],
            ],
            'escalation_2' => [
                'fr' => [
                    'content' => 'Nouvelle relance sans retour de votre part.',
                ],
                'en' => [
                    'content' => 'Second escalation with no response.',
                ],
            ],
            'closure' => [
                'fr' => [
                    'content' => 'Ticket clôturé faute de retour.',
                ],
                'en' => [
                    'content' => 'Ticket closed due to no response.',
                ],
            ],
            'incident_resolution' => [
                'fr' => [
                    'content' => 'Incident résolu.',
                ],
                'en' => [
                    'content' => 'Incident resolved.',
                ],
            ],
            'request_resolution' => [
                'fr' => [
                    'content' => 'Demande traitée.',
                ],
                'en' => [
                    'content' => 'Request completed.',
                ],
            ],
        ];

        foreach ($translations as $slug => $byLang) {
            foreach ($byLang as $code => $values) {
                DB::table('message_translations')->updateOrInsert(
                    [
                        'message_id' => $messages[$slug],
                        'language_id' => $languages[$code],
                    ],
                    [
                        'content' => $values['content'],
                    ]
                );
            }
        }
    }
}
