<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
    //  */
    // public function __invoke(EmailVerificationRequest $request): RedirectResponse
    // {
    //     return 'hehe';

    //     if ($request->user()->hasVerifiedEmail()) {
    //         return redirect()->intended(
    //             config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
    //         );
    //     }

    //     if ($request->user()->markEmailAsVerified()) {
    //         event(new Verified($request->user()));
    //     }

    //     return redirect()->intended(
    //         config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
    //     );
    // }

    public function __invoke(EmailVerificationRequest $request)
    {


        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                config('app.frontend_url')
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            return 'u verified now, hooray. This do nothing to ur account tho. u can use it normally.';
        }


        return redirect()->intended(
            config('app.frontend_url')
        );
    }
}
