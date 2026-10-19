<?php

namespace App\Http\Controllers;

use App\Models\Project;

class QuickMessageController extends Controller
{
    public function index(Project $project)
    {
        $allowedIds = [$project->id];

        $projects = Project::whereIn('id', $allowedIds)
            ->with([
                'projectLanguageSettings.language.setting',
                'categoryColorSetting' => fn ($query) => 
                    $query->with(['fontColor', 'backgroundColor', 'borderTopColor']),
                'messageTypeColorSettings' => fn ($query) => 
                    $query->with(['fontColor', 'backgroundColor', 'borderTopColor']),
                'categories' => fn ($query) => 
                    $query->whereNull('parent_id')
                    ->orderBy('position')
                    ->with([
                    'fontColor', 
                    'backgroundColor',
                    'borderTopColor',
                    'children',
                    'messages' => fn ($query) => 
                        $query->with(['fontColor', 'backgroundColor', 'borderTopColor', 'translations', 'type'])
                        ->orderBy('position')

            ])
        ])->get();

        $selectedProjectId = $project->id;

        return view('quick_messages.index', [
            'projects' => $projects,
            'selectedProjectId' => $selectedProjectId
        ]);
    }
}
