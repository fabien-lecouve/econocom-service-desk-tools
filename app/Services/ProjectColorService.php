<?php

namespace App\Services;

use App\Models\Color;
use App\Models\MessageType;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectColorService
{
    /** @var Collection<string, Color> */
    private Collection $colors;

    /** @var Collection<string, MessageType> */
    private Collection $messageTypes;

    public function initialize(Project $project): void
    {
        $this->colors = Color::select('id', 'code')
            ->get()
            ->keyBy('code');

        $this->messageTypes = MessageType::select('id', 'code')
            ->get()
            ->keyBy('code');

        $this->initializeCategoryColors($project);
        $this->initializeMessageTypeColors($project);
    }

    private function initializeCategoryColors(Project $project): void
    {
        $project->categoryColorSetting()->create([
            'font_color_id' => $this->colors['black-dark']->id,
            'background_color_id' => $this->colors['white']->id,
            'border_top_color_id' => null,
        ]);
    }

    private function initializeMessageTypeColors(Project $project): void
    {
        $defaultColorSettings = [
            'work_note' => 
            [
                'font_color' => 'white',
                'background_color' => 'orange',
            ],
            'comment' => 
            [
                'font_color' => 'black-dark',
                'background_color' => 'white-light',
            ],
            'escalation' => 
            [
                'font_color' => 'white',
                'background_color' => 'yellow',
            ],
        ];

        foreach ($defaultColorSettings as $typeCode => $colorSettings) {
            $messageType = $this->messageTypes[$typeCode];

            $project->messageTypeColorSettings()->create([
                'message_type_id' => $messageType->id,
                'font_color_id' => $this->colors[$colorSettings['font_color']]->id,
                'background_color_id' => $this->colors[$colorSettings['background_color']]->id,
                'border_top_color_id' => null,
            ]);
        }
    }
}