<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showProfilePicture($userId)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function setProfilePicture(Request $request, $userId)
    {
        if (!Auth::check()) {
            return 'identify yo self nigga!';
        }

        // set user profile pic
        return 'sup nigga';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
