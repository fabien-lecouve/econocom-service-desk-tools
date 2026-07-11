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
    public function index()
    {
        $messages = Message::all();

        return view('messages.index', ['messages' => $messages]);
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
    public function store(StoreMessageRequest $request)
    {
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
    public function edit(Message $message)
    {
        return view('messages.edit', ['message' => $message]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        $validated = $request->validated();
        $message->update($validated);

        return redirect()->route('messages.index')->with('success', "Message $message->label modifié");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $label = $message->label;
        $message->delete();

        return redirect()->route('messages.index')->with('success', "Message $label supprimé");
    }
}
