<?php

namespace App\Http\Controllers\Api\V1;

use App\Discharges;
use App\Format;
use App\Idioms;
use App\Mail\Verify;
use App\Medical;
use App\Shortcut;
use App\Slang;
use App\User;
use App\Notice;
use App\Word;
use Carbon\Carbon;
use App\Follower;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Validator;
use JWTAuth;
use Illuminate\Support\Facades\Storage;


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

    // public function getProfile($username)
    // {
    //     $user = User::where('username', $username)->first();

    //     if ($user) {
    //         $title = 'الحساب الشخصي للمستخدم: ' . $user->name;

    //         $words_1 = Word::where('added_by', $user->id)->where('status', 1)->select(DB::raw('title as word'))->paginate(10);
    //     $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 1)->select('en_past as word')->paginate(10);
    //     $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 1)->select('shortcut as word')->paginate(10);
    //     $slang_1 = Slang::where('added_by', $user->id)->where('status', 1)->select('sentence as word')->paginate(10);
    //     $terms_1 = Medical::where('added_by', $user->id)->where('status', 1)->select('title as word')->paginate(10);
    //     $formats_1 = Format::where('added_by', $user->id)->where('status', 1)->select('noun as word')->paginate(10);
    //     $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 1)->select('title as word')->paginate(10);

    //     $this->response = [
    //         'status' => true,
    //         'message' => 'تم التحقق من الحساب بنجاح',
    //         'result' => [
    //             'words' => $words_1,
    //             'discharges' => $discharges_1,
    //             'shortcuts' => $shortcuts_1,
    //             'slang' => $slang_1,
    //             'formats' => $formats_1,
    //             'terms' => $terms_1,
    //             'idioms' => $idioms_1,
    //             ]
    //     ];
    //     return response()->json($this->response);
    //     } else {
    //         $this->response = [
    //         'status' => false,
    //         'message' => 'تم التحقق من الحساب بنجاح',
    //         'result' => [

    //             ]
    //     ];
    //     }
        
    // }

    public function search(Request $request)
    {
        $words = new Word();
        $discharges = new Discharges();
        $shortcuts = new Shortcut();
        $slang = new Slang();
        $terms = new Medical();
        $formats = new Format();
        $idioms = new Idioms();
        if ($request->has('q')) {
        $input = $request->input('q');

            $words = $words->where(function ($query) use ($request) {
                $query->where('title', 'like', $request->input('q'));
                $query->orwhere('translation', 'like', '%' . $request->input('q') . '%');
            })->orderBy('title', 'asc')->get();
            $discharges = $discharges->where(function ($query) use ($request) {
                $query->where('en_past', 'like',$request->input('q'));
                $query->orwhere('en_present', 'like', $request->input('q'));
                $query->orwhere('en_future', 'like', $request->input('q') . '%');
            })->orderBy('en_future', 'asc')->get();
            $shortcuts = $shortcuts->where(function ($query) use ($request) {
                $query->where('shortcut', 'like', $request->input('q'));
                $query->orwhere('mean', 'like', $request->input('q'));
                $query->orwhere('translation', 'like', $request->input('q'));
            })->orderBy('shortcut', 'asc')->get();

            $slang = $slang->where(function ($query) use ($request) {
                $query->where('sentence', 'like', $request->input('q'));
                $query->orwhere('translation', 'like', $request->input('q'));
            })->orderBy('sentence', 'asc')->get();
            $terms = $terms->where(function ($query) use ($request) {
                $query->where('title', 'like', $request->input('q'));
                $query->orwhere('translation', 'like', $request->input('q'));
            })->orderBy('title', 'asc')->get();
            $formats = $formats->where(function ($query) use ($request) {
                $query->where('noun', 'like', $request->input('q'));
                $query->orwhere('verb', 'like', $request->input('q'));
                $query->orwhere('adjective', 'like', $request->input('q'));
                $query->orwhere('adverb', 'like', $request->input('q'));
            })->orderBy('noun', 'asc')->get();
            $idioms = $idioms->where(function ($query) use ($request) {
                $query->where('title', 'like', $request->input('q'));
            })->orderBy('title', 'asc')->get();

            $title = "عملية البحث عن : " . $input;
        }
        // paginate
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => [
                'words' => json_decode(strip_tags($words),true),
                'discharges' => json_decode(strip_tags($discharges),true),
                'shortcuts' => json_decode(strip_tags($shortcuts),true),
                'slang' => json_decode(strip_tags($slang),true),
                'formats' => json_decode(strip_tags($formats),true),
                'terms' => json_decode(strip_tags($terms),true),
                'idioms' => json_decode(strip_tags($idioms),true),
                ]
        ];
        return response()->json($this->response);
        // return view('search', compact(['title', 'words', 'discharges', 'shortcuts', 'slang', 'terms', 'formats', 'idioms']));

    }
    public function words_users_pending()
    {
        $user = Word::where(['added_by' => auth()->user()->id , 'status' => 0])->paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    public function words_users_accepted()
    {
        $user = Word::where(['added_by' => auth()->user()->id , 'status' => 1])->paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    public function words_users_refuse()
    {
        $user = Word::where(['added_by' => auth()->user()->id , 'status' => 3])->paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    public function words_users()
    {
        $user = Word::where('added_by' , auth()->user()->id)->paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    public function works()
    {
        $user = Word::paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    
    // public function notice()
    // {
    //     $notice = Notice::orderBy('created_at', 'desc')->first();
    //     $notice->notice_desc = html_entity_decode($notice->notice_desc);
    //     $this->response = [
    //         // 'status' => true,
    //         // 'message' => 'تم التحقق من الحساب بنجاح',
    //         'result' => ($notice)
    //     ];
    //     return response()->json($this->response);
    // }
    
    
    
    public function Format()
    {
        $user = Format::paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    
    public function Idioms()
    {
        $user = Idioms::paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    
    public function Slang()
    {
        $user = Slang::paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    
    public function Shortcut()
    {
        $user = Shortcut::paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    
    public function Medical()
    {
        $user = Medical::paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }
    
    public function Discharges()
    {
        $user = Discharges::paginate(10);
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
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
                'result' => null
            ];
            return response()->json($this->response);
        }

        // if (auth()->user()->email_verified_at == "null") {
        //     $verify = User::where('email', $request->email)->first();
        //     $verify->sendEmailVerificationNotification();
        //     $this->response = [
        //         'status' => false,
        //         'message' => 'لم يتم تفعيل الحساب, تواصل مع الإدارة لتفعيل حسابك.',
        //         'result' => null
        //     ];
        //     return response()->json($this->response);
        //     //return $this->sendError('لم يتم تفعيل الحساب');
        // }

        $token = str_random(60);
        if (\Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = \Auth::user();
            $user->api_token = $token;
            $user->save();
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


    public function register(Request $request)
    {
        // return response()->json($request);
// // dd($request->all());
//         $validator = Validator::make($request->all(), [
//             'username' => 'required|min:4|max:50|unique:users,username',
//             'name' => 'required',
//             'bio' => 'required',
//             'location' => 'required',
//             'website' => 'required',
//             'email' => 'required|email|unique:users,email',
//             'password' => 'required|min:8|max:60',
//             /*"re_password" => 'required|same:password',*/
//             /*'avatar' => 'mimes:jpeg,bmp,png'*/
//         ], [
            
//             'username.required' => 'حقل إسم المستخدم حقل إجباري.',
//             'email.required' => 'حقل البريد الإلكتروني حقل إجباري.',
//             'password.required' => 'حقل كلمة المرور حقل إجباري.',
//             'website.required' => 'حقل الموقع  حقل إجباري.',
//             'location.required' => 'حقل المكان  حقل إجباري.',
//             'bio.required' => 'حقل السيره نبذه التعريف  حقل إجباري.',
//             /*'re_password.required' => 'حقل تأكيد كلمة المرور حقل إجباري.',*/
//             'username.min' => 'حقل اسم المستخدم اقل من 4 احرف.',
//             'password.min' => 'حقل كلمة المرور اقل من 6 احرف.',
//             /*'password.regex' => 'كلمة المرور يجب ان تكون ثمان احرف وأرقام.',*/
//             /*'re_password.same' => 'تأكد من تطابق كلمتي المرور المدخلات.'*/
//         ]);
        

//         if ($validator->fails()) {
//             $this->response = [
//                 'status' => false,
//                 'message' => $validator->errors()->first(),
//                 'result' => null
//             ];
//             return response()->json($this->response);
//         }
//         $verify_code = rand(10000, 99999);
//         // dd($request->Date_of_birth);
//         $user = User::create([
//             'bio' => $request->bio,
//             'location' => $request->location,
//             'website' => $request->website,
//             'username' => $request->username,
//             'name' => $request->name,
//             'email' => $request->email,
//             'Date_of_birth' => $request->Date_of_birth,
//             'verify_code' => $verify_code,
//             'password' => bcrypt($request->password),
//         ]);
        
//         $role = 3;

//         if (isset($role)) {
//             $role_r = Role::where('id', '=', $role)->firstOrFail();
//             $user->assignRole($role_r); //Assigning role to user
//         }
//         // $verify = User::where('email', $request->email)->first();
//         // $verify->sendEmailVerificationNotification();
//         // \Mail::to($user->email)->send(new Verify($user, $verify_code));
        

//         $token = auth('api')->login($user);
        
        
//         $userfolowers = User::where('id', 10)->first();

//         $userfolowers->followers()->attach($user->id);
        
        Validator::extend('without_spaces', function($attr, $value){
    return preg_match('/^\w{5,}$/', $value);
    
});
        
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'bio' => 'required',
                'full_name' => 'required',
                'username' => 'required|without_spaces|unique:users,username',
                'email' => 'required|email|unique:users,email',
                // 'terms' => 'true',
                // 'password' => 'required|min:8|max:60|regex:/^[A-Za-z][A-Za-z0-9]*$/',
                'password' => 'required',
                // "re_password" => 'required|same:password',
                // 'avatar' => 'mimes:jpeg,bmp,png'
            ], [
                // 'username.required' => 'حقل إسم المستخدم حقل إجباري.',
                'email.required' => 'حقل البريد الإلكتروني حقل إجباري.',
                'email.unique' => ' .البريد الإلكرتوني  موجود بالفعل، يرجى تسجيل بريد  إليكرتوني  جديد',
                
                'username.unique' =>  ' .الإسم  موجود بالفعل، يرجى تسجيل إسم جديد',
                'username.without_spaces' =>  ' يُرجى  التأكد من إسم المستخدم',
                'full_name.required' => 'حقل الإسم الكامل حقل إجباري.',
                'password.required' => 'حقل كلمة المرور حقل إجباري.',
                //  'terms.true' => 'موافقة الشروط حقل إجباري.',

                // 're_password.required' => 'حقل تأكيد كلمة المرور حقل إجباري.',
                'username.min' => 'حقل اسم المستخدم اقل من 4 احرف.',
                // 'password.min' => 'حقل كلمة المرور اقل من 6 احرف.',
                // 'password.regex' => 'كلمة المرور يجب ان تكون ثمان احرف وأرقام.'
            ]);


            if ($validator->fails()) {
                    //  return $request->file('image');
                return response()
                    
                    ->json(['status' => $validator->errors(), 'message' => 'لم تتم العملية بنجاح للأسباب التالية:', 'type' => 'alert-danger']);
                   
            } else {

                    $photo = null;
                if ($request->file('avatar')) {
                    $photo = time() . $request->file('avatar')->hashName();
                    $photo_path = './public/uploads/avatar';
                    $request->file('avatar')->move($photo_path, $photo);
                } else {
                    $photo = 'default.png';
                }
                
           
                //   return response()->json($request);

                $username =  $request->input('full_name');
                
                            $verify_code = rand(10000, 99999);
                            $user = new User();
                            // $user->username = $request->input('username');
                            // $user->username = $username;
                            $user->username = $request->input('username');
                            $user->email = $request->input('email');
                            $user->name = $request->input('full_name');
                            
                            
                            $user->location = $request->input('locale');
                            $user->bio = $request->input('bio');
                            $user->	website = $request->input('personalWebsite');

                            
                            
                            
                            
                            $user->password = bcrypt($request->input('password'));
                            $user->avatar = $photo;
                            $user->verify_code = $verify_code;
                            // dd($user);
                               
                            if (!$user->save()) {
                                return redirect()
                                    ->back()
                                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                                    ->withInput();
                            
                                
                            }
                             
                        // return  redirect('/user/verify-account')->
                        // with(['status' => 'success','mail'=> $user->email,'message' => 'تمت العملية بنجاح سيتم إرسال كود التفعيل في رسالة على بريدك الإلكتروني, شكراً لك.', '
                        // type' => 'alert-success']);
                            
            
                            $role = 3;
            
                            if (isset($role)) {
                                $role_r = Role::where('id', '=', $role)->firstOrFail();
                                $user->assignRole($role_r); //Assigning role to user
                            }
                             $verify = User::where('email', $request->email)->first();
                            //  $verify->sendEmailVerificationNotification();
                                
                        //  $this->sendVerifyLink($verify, $verify_code);
                         
                         
                        //   $verify->sendEmailVerificationNotification();
                             \Mail::to($user->email)->send(new Verify($user, $verify_code));
                         
                            $moof = USER::where('email','moofradat@moofradat.com')->first();
                            $follower = new Follower();
                            $follower->follower_id = $user->id;
                            $follower->leader_id = $moof->id;
                            $follower->save();
        
                $token = auth('api')->login($user);
        
                return response()->json(['token' =>$this->respondWithToken($token),'verify_code'=>$verify_code]);
        
            }
        }
    }
    
     public function get_verification_code()
     {
         $user = JWTAuth::User();
         return response()->json(['verification_code'=>$user->verify_code]);
     }

    public function uploadAvatar(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'avatar' => 'mimes:jpeg,bmp,png'
        ]);
        if ($validator->fails()) {
            $this->response = [
                'status' => false,
                'message' => $validator->errors()->first(),
                'result' => null
            ];
            return response()->json($this->response);
        }

        if (request()->file('avatar')) {
            $photo = time() . $request->file('avatar')->hashName();
            $photo_path = './public/uploads/avatar';
            request()->file('avatar')->move($photo_path, $photo);
        } else {
            $photo = 'default.png';
        } 
        User::where('id', auth('api')->user()->id)->update([
        'avatar' => $photo
        ]);
        



        $this->response = [
            'status' => true,
            'message' => $validator->errors()->first(),
            'result' => [
                'avatar' => url('/'). '/public/uploads/avatar/' . $photo, 
            ]
        ];
        return response()->json($this->response);
    }

    public function uploadCover(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'img' => 'mimes:jpeg,bmp,png'
        ]);
        if ($validator->fails()) {
            $this->response = [
                'status' => false,
                'message' => $validator->errors()->first(),
                'result' => null
            ];
            return response()->json($this->response);
        }


        if ($request->file('img')) {
            $photo = time() . $request->file('img')->hashName();
            $photo_path = './public/uploads/covers';
            $request->file('img')->move($photo_path, $photo);
            User::where('id', auth('api')->user()->id)->update([
            'cover' => $photo
            ]);
        }

        $this->response = [
            'status' => true,
            'message' => $validator->errors()->first(),
            'result' => [
                'cover' => url('/').'/public/uploads/covers/' .$photo
            ]
        ];
        return response()->json($this->response);
    }

    public function getProfile($id)
    {
        $user = User::where('id', $id)->withCount(['followers', 'followings'])->first();

        $user['approved'] = $user->getApprovedWord($user->id);
        $user['pending'] = $user->getPendingWord($user->id);
        $user['declined'] = $user->getDeclinedWord($user->id);

        $user['approved_list'] = $this->getApprovedWord($user->id);
        $user['pending_list'] = $this->getPendingWord($user->id);
        $user['declined_list'] = $this->getDeclinedWord($user->id);


        $this->response = [
            'status' => true,
            'message' => 'تم بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }

    public function getUseProfile($userr)
    {
        $me = User::where('id', auth('api')->user()->id)->with(['followings' => function ($query) use ($userr) {
            $query->where('leader_id', $userr);
        }])->first();


        $user = User::where('id', $userr)->withCount(['followers', 'followings'])->first();
        $has_relation = 0;
        if ($me->followings->count()) {
            $has_relation = 1;
        }

        $user['approved'] = $user->getApprovedWord($user->id);
        $user['pending'] = $user->getPendingWord($user->id);
        $user['declined'] = $user->getDeclinedWord($user->id);

        $user['approved_list'] = $this->getApprovedWord($user->id);
        $user['pending_list'] = $this->getPendingWord($user->id);
        $user['declined_list'] = $this->getDeclinedWord($user->id);

        $this->response = [
            'status' => true,
            'message' => 'تم بنجاح',
            'result' => [
                'user' => $user,
                'has_relation' => $has_relation
            ]
        ];
        return response()->json($this->response);
    }


    public function followUser($user)
    {
        $me = User::where('id', auth('api')->user()->id)->first();
        $user = User::where('id', $user)->first();
        if (!$user) {
            $this->response = [
                'status' => false,
                'message' => 'خطأ',
                'result' => 'خطأ في عملية المتابعة'
            ];
            return response()->json($this->response);
        }
        $user->followers()->attach($me->id);
        $this->response = [
            'status' => true,
            'message' => 'نجاح',
            'result' => 'تمت المتابعة بنجاح'
        ];
        return response()->json($this->response);
    }

    public function unFollowUser($user)
    {
        $me = User::where('id', auth('api')->user()->id)->first();
        $user = User::where('id', $user)->first();

        if (!$user) {
            $this->response = [
                'status' => false,
                'message' => 'خطأ',
                'result' => 'خطأ في عملية إلغاء المتابعة'
            ];
            return response()->json($this->response);
        }
        $user->followers()->detach($me->id);
        $this->response = [
            'status' => true,
            'message' => 'نجاح',
            'result' => 'تم إلغاء المتابعة بنجاح'
        ];
        return response()->json($this->response);

    }


    public function checkVerificationCode(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'code' => 'required',
        ],[
            'code' => 'رمز التحقق',
        ]);

        if ($validator->fails()) {
            $this->response = [
                'status' => false,
                'message' => $validator->errors()->first(),
                'result' => null
            ];
            return response()->json($this->response);
        }

        $user = User::where('email', $request->input('email'))->where('verify_code', $request->input('code'))->first();

        if (!$user) {
            $this->response = [
                'status' => false,
                'message' => 'الكود المدخل خاطئ',
                'result' => null
            ];
            return response()->json($this->response);

        }

        $user->verifed = 1;
        $user->save();

        // $_3mr = User::where('username', '3mr')->first();
        $_moofradat = User::where('username', 'moofradat')->first();

        // $_3mr->followers()->attach($user->id);
        if( $user->username != 'moofradat'){
            
            $_moofradat->followers()->attach($user->id);
        }


        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);
    }

    private function sendVerifyLink($user, $code)
    {
                    \Mail::to('amrsalim2015@gmail.com')->send(new Verify($user, $code));

        // try {
        // } catch (Exception $exception) {
        //     die('die');
        // }
    }


    public function getApprovedWord($id)
    {
        $user = User::where('id', $id)->first();
        $words_1 = Word::where('added_by', $user->id)->where('status', 1)->select('title as word', 'created_at')->paginate(10);
        $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 1)->select('en_past as word', 'created_at')->paginate(10);
        $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 1)->select('shortcut as word', 'created_at')->paginate(10);
        $slang_1 = Slang::where('added_by', $user->id)->where('status', 1)->select('sentence as word', 'created_at')->paginate(10);
        $terms_1 = Medical::where('added_by', $user->id)->where('status', 1)->select('title as word', 'created_at')->paginate(10);
        $formats_1 = Format::where('added_by', $user->id)->where('status', 1)->select('noun as word', 'created_at')->paginate(10);
        $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 1)->select('title as word', 'created_at')->paginate(10);

        //return $words_1;
        $result = [];
        foreach ($words_1 as $item) {
            array_push($result, [
                'word' => $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($discharges_1 as $item) {
            array_push($result, [
                'word' => $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($shortcuts_1 as $item) {
            array_push($result, [
                'word' => 'تمت إضافة الكلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($slang_1 as $item) {
            array_push($result, [
                'word' => 'تمت إضافة الكلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($terms_1 as $item) {
            array_push($result, [
                'word' => 'تمت إضافة الكلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($formats_1 as $item) {
            array_push($result, [
                'word' => 'تمت إضافة الكلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($idioms_1 as $item) {
            array_push($result, [
                'word' => 'تمت إضافة الكلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }


        return $result;
    }

    public function getPendingWord($id)
    {
        $user = User::where('id', $id)->first();
        $words_1 = Word::where('added_by', $user->id)->where('status', 0)->select('title as word', 'created_at')->paginate(10);
        $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 0)->select('en_past as word', 'created_at')->paginate(10);
        $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 0)->select('shortcut as word', 'created_at')->paginate(10);
        $slang_1 = Slang::where('added_by', $user->id)->where('status', 0)->select('sentence as word', 'created_at')->paginate(10);
        $terms_1 = Medical::where('added_by', $user->id)->where('status', 0)->select('title as word', 'created_at')->paginate(10);
        $formats_1 = Format::where('added_by', $user->id)->where('status', 0)->select('noun as word', 'created_at')->paginate(10);
        $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 0)->select('title as word', 'created_at')->paginate(10);

        //return $words_1;
        $result = [];
        foreach ($words_1 as $item) {
            array_push($result, [
                'word' => $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($discharges_1 as $item) {
            array_push($result, [
                'word' => 'بإنتظار الموافقة على كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($shortcuts_1 as $item) {
            array_push($result, [
                'word' => 'بإنتظار الموافقة على كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($slang_1 as $item) {
            array_push($result, [
                'word' => 'بإنتظار الموافقة على كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($terms_1 as $item) {
            array_push($result, [
                'word' => 'بإنتظار الموافقة على كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($formats_1 as $item) {
            array_push($result, [
                'word' => 'بإنتظار الموافقة على كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($idioms_1 as $item) {
            array_push($result, [
                'word' => 'بإنتظار الموافقة على كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }


        return $result;
    }

    public function getDeclinedWord($id)
    {
        $user = User::where('id', $id)->first();
        $words_1 = Word::where('added_by', $user->id)->where('status', 2)->select('title as word', 'created_at')->paginate(10);
        $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 2)->select('en_past as word', 'created_at')->paginate(10);
        $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 2)->select('shortcut as word', 'created_at')->paginate(10);
        $slang_1 = Slang::where('added_by', $user->id)->where('status', 2)->select('sentence as word', 'created_at')->paginate(10);
        $terms_1 = Medical::where('added_by', $user->id)->where('status', 2)->select('title as word', 'created_at')->paginate(10);
        $formats_1 = Format::where('added_by', $user->id)->where('status', 2)->select('noun as word', 'created_at')->paginate(10);
        $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 2)->select('title as word', 'created_at')->paginate(10);

        //return $words_1;
        $result = [];
        foreach ($words_1 as $item) {
            array_push($result, [
                'word' => $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($discharges_1 as $item) {
            array_push($result, [
                'word' => 'للأسباب التالية تم رفض كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($shortcuts_1 as $item) {
            array_push($result, [
                'word' => 'للأسباب التالية تم رفض كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($slang_1 as $item) {
            array_push($result, [
                'word' => 'للأسباب التالية تم رفض كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($terms_1 as $item) {
            array_push($result, [
                'word' => 'للأسباب التالية تم رفض كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($formats_1 as $item) {
            array_push($result, [
                'word' => 'للأسباب التالية تم رفض كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }
        foreach ($idioms_1 as $item) {
            array_push($result, [
                'word' => 'للأسباب التالية تم رفض كلمة ' . $item->word,
                'date' => myDate($item->created_at)
            ]);
        }


        return $result;
    }

    public function getFollowers(User $user)
    {
        //$user = User::where('id', auth('api')->user()->id)->with(['followers'])->first();
        $result = [];
        foreach ($user->followers as $user) {
            array_push($result, $user);
        }
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $result
        ];
        return response()->json($this->response);

    }

    public function getFollowings(User $user)
    {
        //$user = User::where('id', auth('api')->user()->id)->with(['followings'])->first();


        $result = [];
        foreach ($user->followings as $user) {
            array_push($result, $user);
        }
        $this->response = [
            'status' => true,
            'message' => 'تم التحقق من الحساب بنجاح',
            'result' => $result
        ];
        return response()->json($this->response);
    }


    public function updateInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|unique:users,email,' .auth('api')->user()->id,
        ], [
            'email.required' => 'حقل البريد الإلكتروني حقل إجباري.',
        ]);


        if ($validator->fails()) {
            $this->response = [
                'status' => false,
                'message' => $validator->errors()->first(),
                'result' => null
            ];
            return response()->json($this->response);
        }

        $user = User::where('id', auth('api')->user()->id)->first();
        if ($user->email) {
            $user->email = $request->input('email');
        }
        if ($user->name) {
            $user->name = $request->input('name');
        }
        // $user->avatar = $request->input('avatar');
        if ($user->website) {
            $user->website = $request->input('website');
        }
        if ($user->Date_of_birth) {
            $user->Date_of_birth = $request->input('Date_of_birth');
        }
        if ($user->bio) {
            $user->bio = $request->input('bio');
        }
        if ($user->location) {
            $user->location = $request->input('location');
        }
        $user->save();
        $this->response = [
            'status' => true,
            'message' => 'تم تحديث البيانات بنجاح بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);

    }


    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8'
        ], [], [
            'old_password' => 'كلمة المرور الحالية',
            'new_password' => 'كلمة المرور الجديدة'
        ]);


        if ($validator->fails()) {
            $this->response = [
                'status' => false,
                'message' => $validator->errors()->first(),
                'result' => null
            ];
            return response()->json($this->response);
        }

        $user = User::where('id', auth('api')->user()->id)->first();
        if (!\Hash::check($request->input('old_password'), $user->password)) {
            $this->response = [
                'status' => false,
                'message' => 'كلمة المرور الحالية المدخلة خاطئة الرجاء المحاولة مرة أخرى.',
                'result' => null
            ];
            return response()->json($this->response);
        }
        $user->password = bcrypt($request->input('new_password'));
        $user->save();
        $this->response = [
            'status' => true,
            'message' => 'تم تحديث البيانات بنجاح بنجاح',
            'result' => $user
        ];
        return response()->json($this->response);

    }
    public function notice(){
        $contents = Storage::get('notice.txt');
        return ['notice'=>$contents];
    }
    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60

        ]);
    }

}
