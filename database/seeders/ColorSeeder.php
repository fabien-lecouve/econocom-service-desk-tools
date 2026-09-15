<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            // Blanc
            [
                'code' => 'white-light',
                'label' => 'Blanc clair',
                'hex' => '#FFFFFF',
                'position' => 1,
            ],
            [
                'code' => 'white',
                'label' => 'Blanc',
                'hex' => '#F5F5F5',
                'position' => 2,
            ],
            [
                'code' => 'white-dark',
                'label' => 'Blanc foncé',
                'hex' => '#E5E5E5',
                'position' => 3,
            ],

            // Gris
            [
                'code' => 'gray-light',
                'label' => 'Gris clair',
                'hex' => '#D1D5DB',
                'position' => 4,
            ],
            [
                'code' => 'gray',
                'label' => 'Gris',
                'hex' => '#9CA3AF',
                'position' => 5,
            ],
            [
                'code' => 'gray-dark',
                'label' => 'Gris foncé',
                'hex' => '#6B7280',
                'position' => 6,
            ],

            // Noir
            [
                'code' => 'black-light',
                'label' => 'Noir clair',
                'hex' => '#4B5563',
                'position' => 7,
            ],
            [
                'code' => 'black',
                'label' => 'Noir',
                'hex' => '#1F2937',
                'position' => 8,
            ],
            [
                'code' => 'black-dark',
                'label' => 'Noir foncé',
                'hex' => '#111827',
                'position' => 9,
            ],

            // Violet
            [
                'code' => 'purple-light',
                'label' => 'Violet clair',
                'hex' => '#C4B5FD',
                'position' => 10,
            ],
            [
                'code' => 'purple',
                'label' => 'Violet',
                'hex' => '#A78BFA',
                'position' => 11,
            ],
            [
                'code' => 'purple-dark',
                'label' => 'Violet foncé',
                'hex' => '#8B5CF6',
                'position' => 12,
            ],

            // Bleu
            [
                'code' => 'blue-light',
                'label' => 'Bleu clair',
                'hex' => '#93C5FD',
                'position' => 13,
            ],
            [
                'code' => 'blue',
                'label' => 'Bleu',
                'hex' => '#60A5FA',
                'position' => 14,
            ],
            [
                'code' => 'blue-dark',
                'label' => 'Bleu foncé',
                'hex' => '#3B82F6',
                'position' => 15,
            ],

            // Vert
            [
                'code' => 'green-light',
                'label' => 'Vert clair',
                'hex' => '#86EFAC',
                'position' => 16,
            ],
            [
                'code' => 'green',
                'label' => 'Vert',
                'hex' => '#4ADE80',
                'position' => 17,
            ],
            [
                'code' => 'green-dark',
                'label' => 'Vert foncé',
                'hex' => '#22C55E',
                'position' => 18,
            ],

            // Jaune
            [
                'code' => 'yellow-light',
                'label' => 'Jaune clair',
                'hex' => '#FDE047',
                'position' => 19,
            ],
            [
                'code' => 'yellow',
                'label' => 'Jaune',
                'hex' => '#FACC15',
                'position' => 20,
            ],
            [
                'code' => 'yellow-dark',
                'label' => 'Jaune foncé',
                'hex' => '#EAB308',
                'position' => 21,
            ],

            // Orange
            [
                'code' => 'orange-light',
                'label' => 'Orange clair',
                'hex' => '#FDBA74',
                'position' => 22,
            ],
            [
                'code' => 'orange',
                'label' => 'Orange',
                'hex' => '#FB923C',
                'position' => 23,
            ],
            [
                'code' => 'orange-dark',
                'label' => 'Orange foncé',
                'hex' => '#F97316',
                'position' => 24,
            ],

            // Rouge
            [
                'code' => 'red-light',
                'label' => 'Rouge clair',
                'hex' => '#FCA5A5',
                'position' => 25,
            ],
            [
                'code' => 'red',
                'label' => 'Rouge',
                'hex' => '#F87171',
                'position' => 26,
            ],
            [
                'code' => 'red-dark',
                'label' => 'Rouge foncé',
                'hex' => '#EF4444',
                'position' => 27,
            ],
        ];


        foreach ($colors as $color) {
            DB::table('colors')->updateOrInsert(
                ['code' => $color['code']],
                [
                    'label' => $color['label'],
                    'hex' => $color['hex'],
                    'position' => $color['position']
                ]
            );
        }
    }
}
