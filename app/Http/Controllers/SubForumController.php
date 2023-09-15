<?php

namespace App\Http\Controllers;

use App\Models\SubForum;
use App\Models\SubForumMember;
use App\Http\Controllers\Controller;
use App\Models\SubForumMod;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubForumRequest;
use App\Http\Requests\UpdateSubForumRequest;
use Illuminate\Support\Facades\DB;

class SubForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subForums =  SubForum::all();
        $subForums->each(fn ($sub) => $sub->withJoinDetail());
        return $subForums;
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

        try {
            $subForum = new SubForum;
            DB::transaction(function () use ($subForum, $request, $slug) {

                // store new sub forum
                $subForum->name = $request->name;
                $subForum->description = $request->description;
                $subForum->slug = $slug;
                $subForum->save();

                // store current user as the first member
                $subForumMember = new SubForumMember;
                $subForumMember->user_id = Auth::id();
                $subForumMember->sub_forum_id = $subForum->id;
                $subForumMember->save();

                // store current user as the mod and admin
                $subForumMod = new SubForumMod;
                $subForumMod->membership_id = $subForumMember->id;
                $subForumMod->is_admin = true;
                $subForumMod->save();
            });

            return $subForum;
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while creating the sub-forum'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubForum $subForum)
    {
        // return 'asdf';
        return $subForum->withJoinDetail();
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
