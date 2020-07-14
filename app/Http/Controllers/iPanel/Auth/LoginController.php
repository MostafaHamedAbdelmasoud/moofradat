<?php

namespace App\Http\Controllers\iPanel\Auth;

use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class LoginController extends Controller
{

    protected $redirectTo = '/ipanel/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $title = "تسجيل الدخول";
        return view('ipanel.login', compact(['title']));
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->with(['message' => "هناك خطأ ما في تسجيل الدخول", "type" => "bg-danger"])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $username = $request->username;

                if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                    Auth::attempt(['email' => $request->username, 'password' => $request->password], $request->remember);
                } else {
                    Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember);
                }

                if (Auth::check()) {
                    $this->setLog('قام بتسجيل الدخول للوحة التحكم');
                    return redirect()->intended(route('ipanel.dashboard'));
                    //return response()->json(['redirect' => "intended", "url" => "dashboard", "message" => "تم تسجيل الدخول بنجاح انتظر حتى يتم اعادة توجيهك"]);
                } else {
                    return redirect(url(route('ipanel.login')))
                        ->with(['message' => "تأكد من صحة البيانات المدخلة.", "type" => "bg-danger"])
                        ->withErrors($validator)
                        ->withInput();
                }
            }
        }//End Post IF
    }

    public function logout()
    {
        $this->setLog('قام بتسجيل الخروج من لوحة التحكم');
        Auth::logout();
        return redirect('/ipanel/login');
    }

    private function setLog($msg)
    {
        $user = Auth::user();
        $log = New Log();
        $log->user_id = $user->id;
        $log->log_message = $msg;
        if (!$log->save()) {
            return redirect()->back()->with(['message' => 'لم يتم تسجيل العملية', 'type' => 'alert-danger']);
        }
    }


}
