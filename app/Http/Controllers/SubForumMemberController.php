<?php

namespace App\Http\Controllers;

use App\Models\SubForumMember;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubForumMemberRequest;
use App\Http\Requests\UpdateSubForumMemberRequest;
use App\Models\SubForum;

class SubForumMemberController extends Controller
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
    public function store(StoreSubForumMemberRequest $request)
    {
        $existingMembership = SubForumMember
            ::where('sub_forum_id', $request->subForumId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingMembership) {
            $existingMembership->delete();
            // return response('Left subforum', 200);
            return SubForum::find($request->subForumId)->withJoinDetail();
        }

        $subForumMember = new SubForumMember;
        $subForumMember->user_id = Auth::id();
        $subForumMember->sub_forum_id = $request->subForumId;
        $subForumMember->save();

        return SubForum::find($request->subForumId)->withJoinDetail();
        // return response('Joined sub forum', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubForumMember $subForumMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubForumMember $subForumMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubForumMemberRequest $request, SubForumMember $subForumMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubForumMember $subForumMember)
    {
        //
    }
}
