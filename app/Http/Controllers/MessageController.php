<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Category;
use App\Models\Message;
use App\Models\MessageType;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $this->authorize('viewAny', [Message::class, $project]);

        $categories = Category::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with([
                'children',
                'messages' => function ($query) {
                    $query->orderBy('position');
                },
            ])
            ->orderBy('position')
            ->get();

        return view('messages.index', [
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
        $this->authorize('viewAny', [Message::class, $project]);

        $project->load('projectLanguageSettings.language');

        $categories = Category::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('position')
            ->get();

        $categories = $this->mapCategories($categories);

        $types = MessageType::all();

        return view('messages.create', [
            'project' => $project,
            'categories' => $categories,
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request, Project $project)
    {
        $this->authorize('viewAny', [Message::class, $project]);

        $validated = $request->validated();

        $translations = $validated['translations'];
        unset($validated['translations']);

        $project = Project::findOrFail($validated['project_id']);

        $message = DB::transaction(function () use ($validated, $translations, $project) {
            $validated['code'] = Message::generateCode($project);

            $message = Message::create($validated);

            foreach ($translations as $translation) {
                if (! empty($translation['content'])) {
                    $message->translations()->create([
                        'language_id' => $translation['language_id'],
                        'content' => $translation['content'],
                    ]);
                }
            }

            return $message;
        });

        return redirect()
            ->route('projects.show', [
                'project' => $project
            ])
            ->with('success', "Message {$message->label} créé");
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Message $message)
    {
        $this->authorize('update', $message);

        $project->load('projectLanguageSettings.language');

        $message->load('translations');

        $categories = Category::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('position')
            ->get();

        $categories = $this->mapCategories($categories);

        $types = MessageType::all();

        return view('messages.edit', [
            'project' => $project,
            'message' => $message,
            'categories' => $categories,
            'types' => $types,
        ]);
    }

    public function update(
        UpdateMessageRequest $request,
        Project $project,
        Message $message
    ) {
        $this->authorize('update', $message);

        $validated = $request->validated();

        $translations = $validated['translations'];
        unset($validated['translations']);

        DB::transaction(function () use ($validated, $translations, $message) {
            $message->update($validated);

            $submittedLanguageIds = collect($translations)
                ->pluck('language_id');

            /*
         * Supprime les traductions correspondant aux langues présentes
         * dans le formulaire. Elles seront ensuite recréées si leur
         * contenu n'est pas vide.
         */
            $message->translations()
                ->whereIn('language_id', $submittedLanguageIds)
                ->delete();

            foreach ($translations as $translation) {
                if (! empty($translation['content'])) {
                    $message->translations()->create([
                        'language_id' => $translation['language_id'],
                        'content' => $translation['content'],
                    ]);
                }
            }
        });

        return redirect()
            ->route('messages.index', [
                'project' => $project,
            ])
            ->with(
                'success',
                "Message {$message->label} modifié"
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Message $message)
    {
        $this->authorize('delete', Message::class);

        $message->delete();

        return redirect()
            ->route('messages.index', [
                'project' => $project,
            ])
            ->with(
                'success',
                "Message {$message->label} supprimé"
            );
    }
}
