<?php

namespace App\Http\Controllers;

use App\Models\SubForumMember;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubForumMemberRequest;
use App\Http\Requests\UpdateSubForumMemberRequest;
use App\Models\SubForum;
use App\Models\SubForumMod;
use Exception;
use Illuminate\Support\Facades\DB;

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
     * Store a newly created resource in storage.
     */
    public function toggle(StoreSubForumMemberRequest $request)
    {
        $existingMembership = SubForumMember
            ::where('sub_forum_id', $request->subForumId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingMembership) {
            try {
                DB::transaction(function () use ($existingMembership, $request) {
                    $modShip = SubForumMod::where('membership_id', $existingMembership->id)->first();
                    if ($modShip) {
                        $modShip->delete();
                    }

                    $existingMembership->delete();
                });

                return SubForum::find($request->subForumId)->withJoinDetail();
            } catch (Exception $e) {
                return response()->json(
                    [
                        "message" => "error occured when leaving subforum",
                        "error" => $e
                    ],
                    500
                );
            }
        }
        $subForumMember = new SubForumMember;
        $subForumMember->user_id = Auth::id();
        $subForumMember->sub_forum_id = $request->subForumId;
        $subForumMember->save();

        return SubForum::find($request->subForumId)->withJoinDetail();
    }

    /**
     * Display the specified resource.
     */
    public function show(SubForumMember $subForumMember)
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
