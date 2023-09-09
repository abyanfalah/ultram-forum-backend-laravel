<?php

namespace App\Http\Controllers;

use App\Events\NewCommentSent;
use App\Models\Post;
use App\Models\User;
use App\Models\Thread;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
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
    public function store(StorePostRequest $request)
    {

        $post = new Post;
        $post->thread_id = $request->threadId;
        $post->top_parent_post_id = $request->topParentPostId ?? null;
        $post->parent_post_id = $request->parentPostId;
        $post->content = trim($request->content);
        $post->level = $request->level ?? 0;
        $post->user_id = auth()->user()->id;
        $post->save();

        // event(new NewCommentSent($post));
        broadcast(new NewCommentSent($post))->toOthers();

        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    public function showByUser(User $user)
    {
        return $user->posts()->get();
    }

    public function showByThread(Thread $thread)
    {
        return $thread->posts()->get();
    }

    public function showParentByThread(Thread $thread)
    {
        return $thread->parentPosts()->get();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
