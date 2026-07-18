<?php

namespace App\Http\Controllers;

use App\Models\ProjectLanguageSetting;
use App\Http\Requests\StoreProjectLanguageSettingRequest;
use App\Http\Requests\UpdateProjectLanguageSettingRequest;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectLanguageSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $languages = Language::select('id', 'code', 'label')
            ->whereIn('id', $request->languageIds)
            ->get();

        $project = Project::select('id', 'code', 'label')
            ->where('id', $request->projectId)
            ->first();

        return view('project_language_settings.create', [
            'languages' => $languages,
            'project' => $project
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectLanguageSettingRequest $request)
    {
        foreach ($request->languages as $data) {
            ProjectLanguageSetting::create([
                'project_id' => $request->project_id,
                'language_id' => $data['language_id'],
                'signature' => $data['signature'],
                'internal_phone_override' => $data['internal_phone_override'],
                'external_phone_override' => $data['external_phone_override']
            ]);
        }

        return redirect()->route('projects.show', [
            'project' => $request->project_id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectLanguageSetting $projectLanguageSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectLanguageSetting $projectLanguageSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectLanguageSettingRequest $request, ProjectLanguageSetting $projectLanguageSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectLanguageSetting $projectLanguageSetting)
    {
        //
    }
}
