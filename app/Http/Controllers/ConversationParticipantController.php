<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationParticipantRequest;
use App\Http\Requests\UpdateConversationParticipantRequest;
use App\Models\ConversationParticipant;

class ConversationParticipantController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConversationParticipantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ConversationParticipant $conversationParticipant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConversationParticipant $conversationParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConversationParticipantRequest $request, ConversationParticipant $conversationParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConversationParticipant $conversationParticipant)
    {
        //
    }
}
