<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ConversationParticipant;
use App\Http\Requests\StoreConversationRequest;
use App\Http\Requests\UpdateConversationRequest;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // DO NOT be goofy and retrieving all conversations!.
        // Only retrieve user's conversations.

        // $userConversations = Conversation::getUserConversations()->get();
        // return $userConversations;

        return Auth::user()->conversations()->get();
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
    public function store(StoreConversationRequest $request)
    {
        $conversation = new Conversation;
        $conversation->save();

        $participantList = [];


        // set the participants
        $participantIdList = $request->participants;
        foreach ($participantIdList as $participantId) {
            $participant = new ConversationParticipant;
            $participant->user_id = $participantId;
            $participant->conversation_id = $conversation->id;
            $participant->save();
            array_push($participantList, $participant);
        }

        // need to re-retrieve to include eagerloaded prarticipants
        $conversation = Conversation::find($conversation->id);
        return $conversation;
    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConversationRequest $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
