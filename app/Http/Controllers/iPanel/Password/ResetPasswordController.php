<?php

namespace App\Http\Controllers\iPanel\Password;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    //
    //trait for handling reset Password
    use ResetsPasswords;
    protected $redirectTo = '/ipanel/login';

    //Show form to seller where they can reset password
    public function showResetForm(Request $request, $token = null)
    {
        return view('ipanel.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }



}
