<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectLanguageSettingRequest;
use App\Models\Project;

class ProjectLanguageSettingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $project->load('projectLanguageSettings.language');

        return view('project_language_settings.create', [
            'project' => $project
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectLanguageSettingRequest $request, Project $project)
    {
        $validated = $request->validated();

        foreach ($validated['languages'] as $data) {
            $project->projectLanguageSettings()
                ->where('language_id', $data['language_id'])
                ->update([
                    'signature' => $data['signature'],
                    'internal_phone_override' => $data['internal_phone_override'] ?? null,
                    'external_phone_override' => $data['external_phone_override'] ?? null,
                ]);
        }

        return redirect()
            ->route('projects.show', [
            'project' => $project,
        ]);
    }
}
