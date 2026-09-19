<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\MessageType;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectMessageTypeColorSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $black = Color::where('code', 'black-dark')->firstOrFail();
        $white = Color::where('code', 'white-light')->firstOrFail();
        $orange = Color::where('code', 'orange-dark')->firstOrFail();
        $yellow = Color::where('code', 'yellow-dark')->firstOrFail();

        $workNote = MessageType::where('code', 'work_note')->firstOrFail();
        $comment = MessageType::where('code', 'comment')->firstOrFail();
        $escalation = MessageType::where('code', 'escalation')->firstOrFail();

        $projects = Project::select('id')->get();

        $settings = [
            [
                'message_type_id' => $workNote->id,
                'font_color_id' => $white->id,
                'background_color_id' => $orange->id,
                'border_top_color_id' => null,
            ],
            [
                'message_type_id' => $comment->id,
                'font_color_id' => $black->id,
                'background_color_id' => $white->id,
                'border_top_color_id' => null,
            ],
            [
                'message_type_id' => $escalation->id,
                'font_color_id' => $white->id,
                'background_color_id' => $yellow->id,
                'border_top_color_id' => null,
            ],
        ];

        foreach ($projects as $project) {
            foreach ($settings as $setting) {
                DB::table('project_message_type_color_settings')->updateOrInsert(
                    [
                        'project_id' => $project->id,
                        'message_type_id' => $setting['message_type_id'],
                    ],
                    [
                        'font_color_id' => $setting['font_color_id'],
                        'background_color_id' => $setting['background_color_id'],
                        'border_top_color_id' => $setting['border_top_color_id'],
                    ]
                );
            }
        }
    }
}
