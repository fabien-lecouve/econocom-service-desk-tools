<?php

namespace App\Http\Controllers;

use App\Models\MessageTranslation;
use App\Http\Requests\StoreMessageTranslationRequest;
use App\Http\Requests\UpdateMessageTranslationRequest;

class MessageTranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messageTranslations = MessageTranslation::all();

        return view('message_translations.index', ['messageTranslations' => $messageTranslations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('message_translations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageTranslationRequest $request)
    {
        $validated = $request->validated();
        $messageTranslation = MessageTranslation::create($validated);

        return redirect()->route('message-translations.index')->with('success', "Traduction de message $messageTranslation->label créée");
    }

    /**
     * Display the specified resource.
     */
    public function show(MessageTranslation $messageTranslation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MessageTranslation $messageTranslation)
    {
        return view('message_translations.edit', ['messageTranslation' => $messageTranslation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageTranslationRequest $request, MessageTranslation $messageTranslation)
    {
        $validated = $request->validated();
        $messageTranslation->update($validated);

        return redirect()->route('message-translations.index')->with('success', "Traduction de message $messageTranslation->label modifiée");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MessageTranslation $messageTranslation)
    {
        $label = $messageTranslation->label;
        $messageTranslation->delete();

        return redirect()->route('message-translations.index')->with('success', "Traduction de message $label supprimée");
    }
}
