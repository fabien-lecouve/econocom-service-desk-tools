<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('viewAny', Project::class);

        $projects = Project::with('projectLanguageSettings.language')->get();

        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        $languages = Language::pluck('label', 'id');

        return view('projects.create', ['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

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
        $this->authorize('view', $project);

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
        $this->authorize('view', $project);

        $project->load('projectLanguageSettings.language');

        return view('projects.edit', [
            'project' => $project,
            'languages' => Language::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $project) {
            $project->update([
                'label' => $validated['label'],
                'internal_phone' => $validated['internal_phone'] ?? null,
                'external_phone' => $validated['external_phone'] ?? null,
                'email' => $validated['email'] ?? null,
            ]);

            foreach ($validated['languages'] as $language) {
                $project->projectLanguageSettings()->updateOrCreate(
                    [
                        'language_id' => $language['language_id'],
                    ],
                    [
                        'signature' => $language['signature'] ?? null,
                        'internal_phone_override' => $language['internal_phone_override'] ?? null,
                        'external_phone_override' => $language['external_phone_override'] ?? null,
                    ]
                );
            }
        });

        return redirect()
            ->route('projects.show', $project)
            ->with('success', "Le projet {$project->label} a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', Project::class);

        $label = $project->label;
        $project->delete();

        return redirect()->route('projects.index')->with('success', "Projet $label supprimé");
    }
}
