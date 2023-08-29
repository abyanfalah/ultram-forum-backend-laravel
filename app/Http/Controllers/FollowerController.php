<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowerRequest;
use App\Http\Requests\UpdateFollowerRequest;

class FollowerController extends Controller
{

    public function index()
    {
        //
    }


    public function store(StoreFollowerRequest $request)
    {
        $follow = Follower
            ::where('user_id', $request->followeeId)
            ->where('follower_id', auth()->user()->id)
            ->first();


        if ($follow) {
            $follow->delete();
        } else {
            $follow = new Follower;
            $follow->user_id = $request->followeeId;
            $follow->follower_id = auth()->user()->id;
            $follow->save();
        }

        $followee = User::find($request->followeeId);
        return $followee;

        // $data = Follower
        //     ::where('user_id', $followee->id)
        //     // ->where('')
        //     ->count();

        // $isFollowed = Follower
        //     ::where('follower_id', auth()->user()->id)
        //     ->where('user_id', $followee->id)
        //     ->first();

        // return [
        //     "user" => $followee,
        //     "followerCount" => $data,
        //     "isFollowed" => $isFollowed ? true : false,
        // ];
    }


    public function show(Follower $follower)
    {
        //
    }


    public function update(UpdateFollowerRequest $request, Follower $follower)
    {
        //
    }


    public function destroy(Follower $follower)
    {
        //
    }
}
