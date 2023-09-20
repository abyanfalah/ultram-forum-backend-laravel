<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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



    public function showProfilePicture(User $user)
    {
        $headers = [
            'Content-Type' => 'image/*',
        ];

        if ($user->profile_pic == null) {
            return response()->file(storage_path('app/profile_pic/default.jpg'), $headers);
        }

        $filePath = storage_path("app/$user->profile_pic");
        return response()->file($filePath, $headers);
    }

    /**
     * Update the specified resource in storage.
     */
    public function setProfilePicture(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response('No image is being sent', 400);
        }

        if (!$request->file('image')->isValid()) {
            return response('Invalid image', 400);
        }

        $user = User::find(Auth::id());

        try {
            $oldProfilePic = $user->profile_pic;
            if ($oldProfilePic) {
                Storage::delete($oldProfilePic);
            }

            $filePath = $request->file('image')->store('profile_pic');
            $user->profile_pic = $filePath;
            $user->save();

            return response('profile pic updated', 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "error updating profile pic",
                "error" => $e,
            ], 500);
        }
    }


    public function showCoverPicture(User $user)
    {
        $headers = [
            'Content-Type' => 'image/*',
        ];

        if ($user->cover_pic == null) {
            return response()->file(storage_path('app/cover_pic/default.jpg'), $headers);
        }

        $filePath = storage_path("app/$user->cover_pic");
        return response()->file($filePath, $headers);
    }

    /**
     * Update the specified resource in storage.
     */
    public function setCoverPicture(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response('No image is being sent', 400);
        }

        if (!$request->file('image')->isValid()) {
            return response('Invalid image', 400);
        }

        $user = User::find(Auth::id());

        try {
            $oldCoverPic = $user->cover_pic;
            if ($oldCoverPic) {
                Storage::delete($oldCoverPic);
            }

            $filePath = $request->file('image')->store('cover_pic');
            $user->cover_pic = $filePath;
            $user->save();

            return response('cover pic updated', 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "error updating cover pic",
                "error" => $e,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
