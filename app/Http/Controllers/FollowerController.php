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
            ::where('followee_id', $request->followeeId)
            ->where('follower_id', auth()->user()->id)
            ->first();

        $followee = User::find($request->followeeId);

        if ($follow) {
            $follow->delete();
        } else {
            $follow = new Follower;
            $follow->follower_id = auth()->user()->id;
            $follow->followee_id = $followee->id;
            $follow->save();
        }

        return $followee;
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
