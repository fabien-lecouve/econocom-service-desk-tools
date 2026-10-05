<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Message;
use App\Models\MessageType;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $this->authorize('viewAny', [Message::class, $project]);

        $categories = Category::select('id', 'code', 'label')
            ->where('project_id', $project->id)
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $this->authorize('create', [Message::class, $project]);

        $project->load('projectLanguageSettings.language');

        $categories = Category::select('id', 'code', 'label')
            ->where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('position')
            ->get();

        $types = MessageType::select('id', 'code', 'label')
            ->get();

        $defaultType = $types->firstWhere('code', 'comment')?->id;

        $colors = Color::select('id', 'label')
            ->orderBy('position', 'asc')
            ->get();

        return view('messages.create', [
            'project' => $project,
            'categories' => $categories,
            'types' => $types,
            'defaultType' => $defaultType,
            'colors' => $colors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request, Project $project)
    {
        $this->authorize('create', [Message::class, $project]);

        $validated = $request->validated();

        $translations = $validated['translations'];
        unset($validated['translations']);

        $message = DB::transaction(function () use ($validated, $translations, $project) {
            $validated['code'] = Message::generateCode($project);
            $validated['position'] = Message::setPosition('category_id', $validated['category_id']);

            $message = $project->messages()->create($validated);

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
            ->route('projects.messages.index', ['project' => $project])
            ->with('success', "Le message \"$message->label\" a été créé");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Message $message)
    {
        $this->authorize('update', $message);

        $project->load('projectLanguageSettings.language');

        $message->load('translations');

        $categories = Category::select('id', 'code', 'label')
            ->where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('position')
            ->get();

        $types = MessageType::select('id', 'label')
            ->get();

        $colors = Color::select('id', 'label')
            ->orderBy('position', 'asc')
            ->get();

        return view('messages.edit', [
            'project' => $project,
            'message' => $message,
            'categories' => $categories,
            'types' => $types,
            'colors' =>$colors
        ]);
    }

    public function update(UpdateMessageRequest $request, Project $project, Message $message)
    {
        $this->authorize('update', $message);

        $validated = $request->validated();

        $translations = $validated['translations'];
        unset($validated['translations']);

        DB::transaction(function () use ($validated, $translations, $message) {
            $message->update($validated);

            $submittedLanguageIds = collect($translations)
                ->pluck('language_id');

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
            ->route('projects.messages.index', ['project' => $project])
            ->with('success', "Le message \"$message->label\" a été modifié");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Message $message)
    {
        $this->authorize('delete', $message);

        $label = $message->label;

        $message->delete();

        return redirect()
            ->route('projects.messages.index', ['project' => $project])
            ->with('success', "Le message \"$label\" a été supprimé");
    }
}
