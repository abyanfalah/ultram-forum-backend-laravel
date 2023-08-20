<?php

namespace App\Http\Controllers;

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
        $post->parent_post_id = $request->parentPostId;
        $post->content = $request->content;
        $post->user_id = auth()->user()->id;
        $post->likes = 0;
        $post->dislikes = 0;
        $post->save();

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
