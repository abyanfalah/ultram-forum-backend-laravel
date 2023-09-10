<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $users->each(fn ($user) => $user->withFollowDetails());
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }


    public function showByUsername($username)
    {
        $user = User
            ::where('username', $username)
            ->first()
            ->withFollowDetails();
        return $user;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            "name" => 'required',
            // "bio" => 'required',
        ]);

        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->save();
        $user->withFollowDetails();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
