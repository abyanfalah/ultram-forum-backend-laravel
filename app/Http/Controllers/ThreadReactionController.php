<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadReactionRequest;
use App\Http\Requests\UpdateThreadReactionRequest;
use App\Models\Thread;
use App\Models\ThreadReaction;

class ThreadReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(StoreThreadReactionRequest $request)
    {


        $userId = auth()->user()->id;
        $threadId = $request->threadId;
        $isLiking = $request->isLiking;

        // find existing reaction.
        $existingReaction =
            ThreadReaction
            ::where('user_id', $userId)
            ->where('thread_id', $threadId)->first();

        $thread = Thread::find($threadId);

        // if not found store this new one
        if (!$existingReaction) {
            $reaction = new ThreadReaction;
            $reaction->user_id = $userId;
            $reaction->thread_id = $threadId;
            $reaction->is_liking = $isLiking;
            $reaction->save();
            return $thread->getReactionsCount();
        }

        // if found, cancel if same.
        if ($existingReaction->is_liking == $isLiking) {
            $existingReaction->delete();
            return $thread->getReactionsCount();
        }

        // else, renew it.
        $existingReaction->is_liking = $isLiking;
        $existingReaction->save();
        return $thread->getReactionsCount();
    }

    /**
     * Display the specified resource.
     */
    public function show(ThreadReaction $threadReaction)
    {
    }

    public function showByThread(Thread $thread)
    {
        return $thread->getReactionsCount();
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThreadReaction $threadReaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThreadReactionRequest $request, ThreadReaction $threadReaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThreadReaction $threadReaction)
    {
        //
    }
}
