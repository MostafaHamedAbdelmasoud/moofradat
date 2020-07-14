<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAuthController extends Controller
{
    public function logoutUser()
    {
        if (\Auth::check()) {
            \Auth::logout();
        }
        return redirect('/');
    }
}
