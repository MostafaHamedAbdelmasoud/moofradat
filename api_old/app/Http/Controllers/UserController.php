<?php

namespace App\Http\Controllers;

use App\Discharges;
use App\Idioms;
use App\Job;
use App\Medical;
use App\Shortcut;
use App\Slang;
use App\Format;
use App\User;
use App\Word;
use App\Ads;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class UserController extends Controller
{
    private $response;

    public function __construct()
    {
        $this->response = [];
    }

    public function test()
    {
        return 'AABBCC';
    }

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'حقل البريد الإلكتروني إجباري',
            'email.email' => 'حقل البريد الإلكتروني صيغته خاطئة',
            'password.required' => 'حقل كلمة المرور إجباري',
        ], [
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور'
        ]);

        if ($validator->fails()) {
            $this->response = [
                'status' => false,
                'message' => $validator->errors()->first(),
                'result' => null
            ];
            return response()->json($this->response);
        }
        $user = User::where('email', $request->input('email'))->first();
        if (is_null($user)) {
            $this->response = [
                'status' => false,
                'message' => 'خطأ في البريد الإلكتروني أو كلمة المرور',
                'result' => []
            ];
            return response()->json($this->response);
        }

        if (!$user->verified) {
            $this->response = [
                'status' => false,
                'message' => 'لم يتم تفعيل الحساب, تواصل مع الإدارة لتفعيل حسابك.',
                'result' => null
            ];
            return response()->json($this->response);
            //return $this->sendError('لم يتم تفعيل الحساب');
        }

        $token = str_random(60);
        if (\Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = null;//\Auth::user();
            $this->response = [
                'status' => true,
                'message' => 'تم تسجيل الدخول بنجاح',
                'result' => $user
            ];
            return response()->json($this->response);
        } else {
            $this->response = [
                'status' => false,
                'message' => 'خطأ في البريد الإلكتروني او كلمة المرور',
                'result' => null
            ];
            return response()->json($this->response);
        }

    }

    public function followUser($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            $this->response = [
                'status' => false,
                'message' => 'خطأ',
                'result' => 'خطأ في عملية المتابعة'
            ];
            return response()->json($this->response);
        }
        $user->followers()->attach(\Auth::user()->id);
        $this->response = [
            'status' => true,
            'message' => 'نجاح',
            'result' => 'تمت المتابعة بنجاح'
        ];
        return response()->json($this->response);
    }

    public function unFollowUser($username)
    {

        $user = User::where('username', $username)->first();
        if (!$user) {
            $this->response = [
                'status' => false,
                'message' => 'خطأ',
                'result' => 'خطأ في عملية إلغاء المتابعة'
            ];
            return response()->json($this->response);
        }
        $user->followers()->detach(\Auth::user()->id);
        $this->response = [
            'status' => true,
            'message' => 'نجاح',
            'result' => 'تم إلغاء المتابعة بنجاح'
        ];
        return response()->json($this->response);

    }

}
