<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        $validated = $request->validated();
        $message = Message::create($validated);

        return redirect()->route('messages.index')->with('success', "Message $message->label créé");
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
