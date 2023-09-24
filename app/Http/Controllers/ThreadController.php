<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Models\SubForum;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Thread::orderBy('created_at', 'desc')->get();
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
        $request->validate([
            "title" => "required",
            "content" => "required",
        ]);


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
        $thread->content = trim($request->content);
        $thread->user_id = auth()->user()->id;
        $thread->sub_forum_id = $request->subForumId ?? null;
        $thread->slug = trim($slug);
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

    public function showBySubForumId($subForumId)
    {
        return 'this function is disabled';
    }

    public function showBySubForum(SubForum $subForum)
    {
        return $subForum->threads()->get();
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
