<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\UpdateThreadRequest;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Thread::all();
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
    public function store(StoreThreadRequest $request)
    {
        // validation?? later


        $slug = $request->slug;
        $i = 1;

        $isUniqueSlug = false;
        while ($isUniqueSlug == false) {
            $foundSlug = Thread::where('slug', $slug)->first();

            if (!$foundSlug) {
                $isUniqueSlug = true;
            } else {
                $slug = $request->slug . "_$i";
                $i++;
            }
        }

        // store to db
        $thread = new Thread;
        $thread->title = trim($request->title);
        $thread->category_id = $request->categoryId;
        $thread->content = trim($request->content);
        $thread->user_id = auth()->user()->id;
        $thread->slug = $slug;
        $thread->save();

        return $thread;
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread)
    {
        return $thread;
    }

    public function showByUser(User $user)
    {
        return $user->threads()->get();
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThreadRequest $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        //
    }
}