<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostReaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostReactionRequest;
use App\Http\Requests\UpdatePostReactionRequest;

class PostReactionController extends Controller
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
    public function store(StorePostReactionRequest $request)
    {


        $userId = auth()->user()->id;
        $postId = $request->postId;
        $isLiking = $request->isLiking;

        $post = Post::find($postId);

        // find existing reaction.
        $existingReaction =
            PostReaction
            ::where('user_id', $userId)
            ->where('post_id', $postId)->first();



        // if not found store this new one
        if (!$existingReaction) {
            $reaction = new PostReaction;
            $reaction->user_id = $userId;
            $reaction->post_id = $postId;
            $reaction->is_liking = $isLiking;
            $reaction->save();
            return $post->getReactionsCount();
        }


        // if found, cancel if same.
        if ($existingReaction->is_liking == $isLiking) {
            $existingReaction->delete();
            return $post->getReactionsCount();
        }

        // else, renew it.
        $existingReaction->is_liking = $isLiking;
        $existingReaction->save();
        return $post->getReactionsCount();
    }

    /**
     * Display the specified resource.
     */
    public function show(PostReaction $postReaction)
    {
        //
    }

    public function showByPost(Post $post)
    {
        return $post->getReactionsCount();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostReaction $postReaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostReactionRequest $request, PostReaction $postReaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostReaction $postReaction)
    {
        //
    }
}
