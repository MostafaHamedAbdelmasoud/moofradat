<?php

namespace App\Http\Controllers\iPanel;

use App\Log;
use App\Mail\Verify;
use App\Notifications\VerfiyAccount;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mail;
use Notification;
use Spatie\Permission\Models\Role;
use Validator;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "إدارة المستخدمين";
        $users = User::paginate(20);
        return view('ipanel.users.index', compact(['title', 'users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "إنشاء مستخدم";
        $roles = Role::get();
        return view('ipanel.users.create', compact(['title', 'roles']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:users,username',
                'full_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|max:60',
                "re_password" => 'required|same:password',
                'avatar' => 'mimes:jpeg,bmp,png'
            ], [
                'username.required' => 'حقل :attribute حقل إجباري.',
                'email.required' => 'حقل :attribute حقل إجباري.',
                'full_name.required' => 'حقل :attribute حقل إجباري.',
                'password.required' => 'حقل :attribute حقل إجباري.',
                're_password.required' => 'حقل :attribute حقل إجباري.',
                // 'username.min' => 'حقل اسم المستخدم اقل من 5 احرف.',
                // 'password.min' => 'حقل كلمة المرور اقل من 6 احرف.',
                're_password.same' => 'تأكد من تطابق كلمتي المرور المدخلات.'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {

                if ($request->file('avatar')) {
                    $photo = time() . $request->file('avatar')->hashName();
                    $photo_path = './public/uploads/avatar';
                    $request->file('avatar')->move($photo_path, $photo);
                } else {
                    $photo = 'default.png';
                }

                $user = new User();
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                $user->name = $request->input('full_name');
                $user->password = bcrypt($request->input('password'));
                $user->avatar = $photo;

                if (!$user->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $role = $request->input('role');

                if (isset($role)) {
                    $role_r = Role::where('id', '=', $role)->firstOrFail();
                    $user->assignRole($role_r); //Assigning role to user
                }
                $verify = User::where('email', $request->email)->first();
                $this->sendVerifyLink($verify);

                $this->setLog('قام بإضافة مستخدم جديد');
                return redirect()->back()->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        $title = "تعديل المستخدم: " . $user->name;
        $roles = Role::get();
        if (!$user) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على المستخدم.', 'type' => 'alert-danger']);
        }

        return view('ipanel.users.show', compact(['user', 'title', 'roles']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        if ($request->isMethod('post')) {

            $user = User::find($id);


            if ($request->input('password') && $request->input('re_password')) {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|unique:users,username,' . $id,
                    'full_name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'password' => 'required|max:60',
                    "re_password" => 'same:password',
                    'avatar' => 'mimes:jpeg,bmp,png'
                ], [
                    'username.required' => 'حقل :attribute حقل إجباري.',
                    'email.required' => 'حقل :attribute حقل إجباري.',
                    'password.required' => 'حقل :attribute حقل إجباري.',
                    'full_name.required' => 'حقل :attribute حقل إجباري.',
                    // 'username.min' => 'حقل اسم المستخدم اقل من 5 احرف.',
                    // 'password.min' => 'حقل كلمة المرور اقل من 6 احرف.',
                    're_password.same' => 'تأكد من تطابق كلمتي المرور المدخلات.'
                ]);
                $user->password = bcrypt($request->input('password'));
            } else {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|unique:users,username,' . $id,
                    'full_name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'avatar' => 'mimes:jpeg,bmp,png'
                ], [
                    'username.required' => 'حقل :attribute حقل إجباري.',
                    'email.required' => 'حقل :attribute حقل إجباري.',
                    'full_name.required' => 'حقل :attribute حقل إجباري.'
                    // 'username.min' => 'حقل اسم المستخدم اقل من 5 احرف.',
                ]);
            }

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {


                // $2y$10$jsmye7TvsOFOc4KDHSEwyeuG7yCoy6hK32h.oLLgOPdxj4l5eenFy === 123456
                if ($request->file('avatar')) {
                    $photo = time() . $request->file('avatar')->hashName();
                    $photo_path = './public/uploads/avatar';
                    $request->file('avatar')->move($photo_path, $photo);
                    $user->avatar = $photo;
                }

                $user->username = $request->input('username');
                $user->email = $request->input('email');
                $user->name = $request->input('full_name');
                $user->verifed = $request->input('verifed');
                $user->blue_mark = $request->input('blue_mark');

                if (!$user->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $role = $request->input('role');
                if (isset($role)) {
                    $user->roles()->sync($role);  //If one or more role is selected associate user to roles
                } else {
                    $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
                }
                $this->setLog('قام بتعديل العضو ' . $user->name);
                return redirect()->back()->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return redirect(route('users.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف المستخدم ' . $user->name);

        $user->forceDelete();
        return redirect()->back()->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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


    private function sendVerifyLink($user)
    {
        try {
            Notification::send($user, new VerfiyAccount($user));
        } catch (Exception $exception) {
            die('die');
        }
    }

    public function RequestVerify($id)
    {
        $user = User::find($id);
        if ($user->verifed == 0) {
            try {
                Notification::send($user, new VerfiyAccount($user));
                return redirect()
                    ->back()
                    ->with(['message' => 'تم إرسال رسالة التفعيل.', 'type' => 'alert-success']);
            } catch (Exception $exception) {
                die('die');
            }
        } else {
            return redirect()
                ->back()
                ->with(['message' => 'الحساب مفعل مسبقاً', 'type' => 'alert-danger']);
        }
    }
}
