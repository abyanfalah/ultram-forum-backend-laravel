<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubForumRequest;
use App\Http\Requests\UpdateSubForumRequest;
use App\Models\SubForum;

class SubForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SubForum::all();
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
    public function store(StoreSubForumRequest $request)
    {
        $request->validate([
            "name" => "required",
            "description" => "required",
            "slug" => "required",
        ]);

        $slug = $request->slug;
        $i = 1;

        $isUniqueSlug = false;
        while ($isUniqueSlug == false) {
            $foundSlug = SubForum::where('slug', $slug)->first();
            if (!$foundSlug) {
                $isUniqueSlug = true;
            } else {
                $slug = $request->slug . "_$i";
                $i++;
            }
        }

        $subForum = new SubForum;
        $subForum->name = $request->name;
        $subForum->description = $request->description;
        $subForum->slug = $slug;
        $subForum->save();

        return $subForum;
    }

    /**
     * Display the specified resource.
     */
    public function show(SubForum $subForum)
    {
        // return 'asdf';
        return $subForum;
    }

    public function joinSubForum($subForumId)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubForum $subForum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubForumRequest $request, SubForum $subForum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubForum $subForum)
    {
        //
    }
}
