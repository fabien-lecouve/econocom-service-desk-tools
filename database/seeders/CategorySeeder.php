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
                'slug' => 'general',
                'project_id' => 1
            ],
            [
                'parent_id' => null,
                'font_color_id' => null,
                'background_color_id' => null,
                'border_top_color_id' => null,
                'name' => 'général',
                'position' => 1
            ]
        );

        $generalId = DB::table('categories')
            ->where('slug', 'general')
            ->whereNull('project_id')
            ->value('id');

        // Enfant : relances
        DB::table('categories')->updateOrInsert(
            [
                'slug' => 'escalations',
                'project_id' => 1
            ],
            [
                'parent_id' => $generalId,
                'font_color_id' => null,
                'background_color_id' => null,
                'border_top_color_id' => null,
                'name' => 'escalades',
                'position' => 1
            ]
        );

        // Enfant : résolution
        DB::table('categories')->updateOrInsert(
            [
                'slug' => 'resolution',
                'project_id' => 1
            ],
            [
                'parent_id' => $generalId,
                'font_color_id' => null,
                'background_color_id' => null,
                'border_top_color_id' => null,
                'name' => 'résolution',
                'position' => 2
            ]
        );
    }
}
