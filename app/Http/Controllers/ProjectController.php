<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Concerns\HasCode;
use App\Models\Language;

class ProjectController extends Controller
{
    use HasCode;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('projectLanguageSettings.language')->get();

        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::pluck('label', 'id');

        return view('projects.create', ['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        $project = Project::create($validated);

        return redirect()->route('project-language-settings.create', [
            'languageIds' => $request->languages,
            'projectId' => $project->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('projectLanguageSettings.language');

        return view('projects.show', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $project->update($validated);

        return redirect()->route('projects.index')->with('success', "Projet $project->label modifié");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $label = $project->label;
        $project->delete();

        return redirect()->route('projects.index')->with('success', "Projet $label supprimé");
    }
}
