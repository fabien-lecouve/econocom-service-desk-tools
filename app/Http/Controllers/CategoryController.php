<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Project;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $this->authorize('viewAny', [Category::class, $project]);

        $categories = Category::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('position')
            ->get();

        $categories = $this->mapCategories($categories);

        return view('categories.index', [
            'project' => $project,
            'categories' => $categories,
        ]);
    }

    private function mapCategories($categories)
    {
        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'code' => $category->code,
                'label' => $category->label,
                'position' => $category->position,
                'children' => $this->mapCategories($category->children),
            ];
        })->values();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $this->authorize('viewAny', [Category::class, $project]);

        $categories = Category::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('position')
            ->get();

        $categories = $this->mapCategories($categories);

        return view('categories.create', [
            'project' => $project,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request, Project $project)
    {
        $this->authorize('viewAny', [Category::class, $project]);

        $validated = $request->validated();

        $project = Project::findOrFail($validated['project_id']);

        $validated['code'] = Category::generateCode($project);
        $category = Category::create($validated);

        return redirect()->route('projects.show', [
            'project' => $project
        ])->with('success', "Catégorie $category->label créée");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Category $category)
    {
        $this->authorize('update', $category);

        $categories = Category::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('position')
            ->get();

        $categories = $this->mapCategories($categories);

        return view('categories.edit', [
            'project' => $project,
            'category' => $category,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Project $project, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validated();

        $category->update($validated);

        return redirect()
            ->route('categories.index', $project)
            ->with('success', "La catégorie « {$category->label} » a été modifiée.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Category $category)
    {
        $this->authorize('delete', Category::class);

        $label = $category->label;

        $category->delete();

        return redirect()
            ->route('categories.index', $project)
            ->with('success', "La catégorie « {$label} » a été supprimée.");
    }
}
