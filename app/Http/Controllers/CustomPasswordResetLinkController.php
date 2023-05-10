<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use App\Models\User;

class CustomPasswordResetLinkController extends Controller
{
        /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(Request $request): Responsable
    {
        $request->validate([Fortify::email() => 'required|email']);
        $user = User::where('email', $request->email)->first();   

        if($user->active == false){
            $status = 'Účet je neaktívny';
            return app(FailedPasswordResetLinkRequestResponse::class, ['status' => $status]);
        }
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::email())
        );

        return $status == Password::RESET_LINK_SENT
                    ? app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $status])
                    : app(FailedPasswordResetLinkRequestResponse::class, ['status' => $status]);
    }

        /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }
}
