<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCategoryColorSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $black = Color::where('code', 'black-dark')->firstOrFail();
        $white = Color::where('code', 'white')->firstOrFail();

        $projects = Project::select('id')->get();

        foreach ($projects as $project) {
            DB::table('project_category_color_settings')->updateOrInsert(
                ['project_id' => $project->id],
                [
                    'font_color_id' => $black->id,
                    'background_color_id' => $white->id,
                    'border_top_color_id' => null
                ]
            );
        }
    }
}
