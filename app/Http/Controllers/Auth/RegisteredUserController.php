<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            // 'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'min:8'],
        ]);

        $user = User::create([
            'name' => trim($request->username),
            'username' => trim($request->username),
            'email' => trim($request->email),
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));

        Auth::login($user);

        // return response()->noContent();
        return $user;
    }

    public function usernameCheck(Request $request)
    {
        $username = $request->username;

        $result = User::where('username', $username)->first();

        if (!$result)
            return true;

        return false;
    }

    public function emailCheck(Request $request)
    {
        $email = $request->email;

        $result = User::where('email', $email)->first();

        if (!$result)
            return true;

        return false;
    }
}
