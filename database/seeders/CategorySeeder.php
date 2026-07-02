<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Catégorie parente : général
        DB::table('categories')->updateOrInsert(
            [
                'code' => 'general',
                'project_id' => 1
            ],
            [
                'parent_id' => null,
                'font_color_id' => null,
                'background_color_id' => null,
                'border_top_color_id' => null,
                'label' => 'général',
                'position' => 1
            ]
        );

        $generalId = DB::table('categories')
            ->where('code', 'general')
            ->where('project_id', 1)
            ->value('id');

        // Enfant : relances
        DB::table('categories')->updateOrInsert(
            [
                'code' => 'escalations',
                'project_id' => 1
            ],
            [
                'parent_id' => $generalId,
                'font_color_id' => null,
                'background_color_id' => null,
                'border_top_color_id' => null,
                'label' => 'escalades',
                'position' => 1
            ]
        );

        // Enfant : résolution
        DB::table('categories')->updateOrInsert(
            [
                'code' => 'resolution',
                'project_id' => 1
            ],
            [
                'parent_id' => $generalId,
                'font_color_id' => null,
                'background_color_id' => null,
                'border_top_color_id' => null,
                'label' => 'résolution',
                'position' => 2
            ]
        );
    }
}
