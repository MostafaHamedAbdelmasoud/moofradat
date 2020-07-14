<?php

namespace App\Http\Controllers;

use App\Discharges;
use App\Follower;
use App\Format;
use App\Idioms;
use App\Mail\Verify;
use App\Medical;
use App\Notifications\VerfiyAccount;
use App\Shortcut;
use App\Slang;
use App\User;
use App\Word;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Notification;
use Spatie\Permission\Models\Role;
use Validator;
use Image;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
class UsersController extends Controller
{

    public function __construct()
    {
        \App::setLocale('ar');

    }

    public function makeUser(Request $request)
    {
        
        //     $FullName =  $request->input('full_name');
        //         $splitName = explode(' ', $FullName, 2); // Restricts it to only 2 values, for names like Billy Bob Jones

        //     $first_name = $splitName[0];
        //     $last_name = !empty($splitName[1]) ? $splitName[1] : ''; // If last name doesn't exist, make it empty
                            
        //     $username = $first_name .$last_name;
        
        // $request->request->add(['username' => $username]);
        Validator::extend('without_spaces', function($attr, $value){
    return preg_match('/^\w{5,}$/', $value);
    
});
        
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'bio' => 'required',
                'full_name' => 'required',
                'username' => 'required|without_spaces|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'terms' => 'true',
                // 'password' => 'required|min:8|max:60|regex:/^[A-Za-z][A-Za-z0-9]*$/',
                'password' => 'required',
                // "re_password" => 'required|same:password',
                'avatar' => 'mimes:jpeg,bmp,png'
            ], [
                // 'username.required' => 'حقل إسم المستخدم حقل إجباري.',
                'email.required' => 'حقل البريد الإلكتروني حقل إجباري.',
                'email.unique' => ' .البريد الإلكرتوني  موجود بالفعل، يرجى تسجيل بريد  إليكرتوني  جديد',
                
                'username.unique' =>  ' .الإسم  موجود بالفعل، يرجى تسجيل إسم جديد',
                'username.without_spaces' =>  ' يُرجى  التأكد من إسم المستخدم',
                'full_name.required' => 'حقل الإسم الكامل حقل إجباري.',
                'password.required' => 'حقل كلمة المرور حقل إجباري.',
                 'terms.true' => 'موافقة الشروط حقل إجباري.',

                // 're_password.required' => 'حقل تأكيد كلمة المرور حقل إجباري.',
                'username.min' => 'حقل اسم المستخدم اقل من 4 احرف.',
                'password.min' => 'حقل كلمة المرور اقل من 6 احرف.',
                'password.regex' => 'كلمة المرور يجب ان تكون ثمان احرف وأرقام.'
                // 're_password.same' => 'تأكد من تطابق كلمتي المرور المدخلات.'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية:', 'type' => 'alert-danger'])
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
                            if (!$user->save()) {
                                return redirect()
                                    ->back()
                                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                                    ->withInput();
                            }
            
                            $role = 3;
            
                            if (isset($role)) {
                                $role_r = Role::where('id', '=', $role)->firstOrFail();
                                $user->assignRole($role_r); //Assigning role to user
                            }
                             $verify = User::where('email', $request->email)->first();
                            //  $verify->sendEmailVerificationNotification();
                                
                         $this->sendVerifyLink($verify, $verify_code);
                         
                         
                            $moof = USER::where('email','moofradat@moofradat.com')->first();
                            $follower = new Follower();
                            $follower->follower_id = $user->id;
                            $follower->leader_id = $moof->id;
                            $follower->save();
                           // $this->setLog('قام بإضافة مستخدم جديد');
                           
                        //   return view('verify_account', ['status' => 'success','mail'=> 
                        // $user->email,'message' => 'تمت العملية بنجاح سيتم إرسال كود التفعيل في رسالة على بريدك الإلكتروني, شكراً لك.', '
                        // type' => 'alert-success','title' => "تم تسجيلك بنجاح"]);
                        
                        
                        
                        return  redirect('/user/verify-account')->
                        with(['status' => 'success','mail'=> $user->email,'message' => 'تمت العملية بنجاح سيتم إرسال كود التفعيل في رسالة على بريدك الإلكتروني, شكراً لك.', '
                        type' => 'alert-success']);
                        
                        
                // return redirect('/signup/success')->with(['status' => 'success', 'message' => 'تمت العملية بنجاح سيتم إرسال كود التفعيل في رسالة على بريدك الإلكتروني, شكراً لك.', 'type' => 'alert-success']);
            
                // }
                    
                }
        }
    }

    public function makeLogin(Request $request)
    {
        
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required|min:6',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->with(['status' => 'error', 'message' => "هناك خطأ ما في تسجيل الدخول", "type" => "bg-danger"])
                    ->withErrors($validator)
                    ->withInput();
            } else {

                //return $request->all();


                // $user_data =  User::where('email',$request->input('email') )->first()();
                // dd($user_data);
                // $verifyed = $user_data->verifed;
                // if(!$verifyed){
                //     return redirect()->back()
                //     ->with(['status' => 'error', 'message' => "تأكد من تفعيل حسابك عن طريق البريد الإلكتروني", "type" => "bg-danger"]);
                //     // ->withErrors($validator)
                //     // ->withInput();
                // } 

                $username = $request->input('email');

                if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                    Auth::attempt(['email' => $username, 'password' => $request->password], $request->remember);
                } else {
                    Auth::attempt(['username' => $username, 'password' => $request->password], $request->remember);
                }

                //Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember);

                if (Auth::check()) {
                    return redirect()->to('/');
                } else {
                    return redirect()
                        ->to('/login')
                        ->with(['status' => 'error', 'message' => "تأكد من صحة البيانات المدخلة.", "type" => "bg-danger"])
                        ->withErrors($validator)
                        ->withInput();
                }


                //  elseif (Auth::check() && ! Auth::user()->email_verified_at == "null") {
                //     // return redirect('/' , Auth::user()->username);
                //     // dd(Auth::user()->username);
                //     Auth::logout();
                //     return redirect()
                //         ->to('/login')
                //         ->with(['status' => 'error', 'message' => "حسابك الشخصي غير فعلا بعد.", "type" => "bg-danger"])
                //         ->withErrors($validator)
                //         ->withInput();
                // } elseif (Auth::check() && Auth::user()->hasVerifiedEmail()) {
                // }

            }
        }//End Post IF
    }

    public function checkUserCode(Request $request)
    {
        $user = User::where('verify_code', $request->input('code'))->first();
        if (!$user) {
            return redirect()
                ->back()
                ->with(['status' => 'error', 'message' => 'الرجاء التأكد من الكود المدخل', 'type' => 'alert-danger'])
                ->withInput();
        }

        if ($user->email == $request->input('email')) {

            $user->verifed = 1;
            $user->save();

    
            $content = 'تم تفعيل حسابك بنجاح يمكنك الأن تسجيل الدخول بحسابك والتفاعل داخل الموقع.';
            $title = "تفعيل حسابك بنجاح";

            return view('front_page', compact(['content', 'title']));
        }

        return redirect()
            ->back()
            ->with(['status' => 'error', 'message' => 'هناك خطأ في العملية الرجاء التأكد من المدخلات.', 'type' => 'alert-danger'])
            ->withInput();

    }

    private function sendVerifyLink($user, $code)
    {
        try {
            \Mail::to($user)->send(new Verify($user, $code));
            
        } catch (Exception $exception) {
            die('die');
        }
    }


//     public function updateUserInfo(Request $request)
//     {
//         if ($request->isMethod('post')) {
//             $validator = Validator::make($request->all(), [
//                 'name' => 'required',
//                 'email' => 'required|email|unique:users,email,' . Auth::user()->id,
//                 //'avatar' => 'mimes:jpeg,bmp,png'
//             ], [
//                 'username.required' => 'حقل :attribute حقل إجباري.',
//                 'email.required' => 'حقل :attribute حقل إجباري.',
//                 'name.required' => 'حقل :attribute حقل إجباري.',
//                 'username.min' => 'حقل اسم المستخدم اقل من 5 احرف.',
//             ]);

//             if ($validator->fails()) {
//                 return redirect()
//                     ->back()
//                     ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية:', 'type' => 'alert-danger'])
//                     ->withErrors($validator)
//                     ->withInput();
//             } else {

//                 if ($request->file('avatar')) {
//                     $photo = time() . $request->file('avatar')->hashName();
//                     $photo_path = './public/uploads/avatar';
//                     $request->file('avatar')->move($photo_path, $photo);
//                 }

//                 $user = Auth::user();
//                 $user->email = $request->input('email');
//                 $user->name = $request->input('name');
//                 $user->bio = $request->input('bio');
//                 $user->location = $request->input('location');
//                 $user->website = $request->input('website');

//                 if (!$user->save()) {
//                     return redirect()
//                         ->back()
//                         ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
//                         ->withInput();
//                 }

//                 return redirect()->back()->with(['status' => 'success', 'message' => 'تمت العملية بنجاح ', 'type' => 'alert-success']);
//             }
//         }
//     }

//     public function updatePassword(Request $request)
//     {
//         $user = Auth::user();
//         if ($request->isMethod('post')) {
//             $validator = Validator::make($request->all(), [
//                 'old_password' => 'required|min:5|max:50',
//                 'password' => 'required|confirmed|min:5|max:50',
//                 'avatar' => 'mimes:jpeg,bmp,png'
//             ], [
//                 'old_password.required' => 'حقل كلمة المرور الحالية إجباري',
//                 'password.required' => 'حقل :attribute حقل إجباري.',
//             ]);

//             if ($validator->fails()) {
//                 return redirect()
//                     ->back()
//                     ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية:', 'type' => 'alert-danger'])
//                     ->withErrors($validator)
//                     ->withInput();
//             } else {
//                 if (!\Hash::check($request->input('old_password'), $user->password)) {
//                     return redirect()
//                         ->back()
//                         ->with(['status' => 'error', 'message' => 'كلمة المرور الحالية غير صحيح الرجاء التأكد من المدخلات', 'type' => 'alert-danger'])
//                         ->withInput();
//                 }

//                 if ($request->file('avatar')) {
//                     $photo = time() . $request->file('avatar')->hashName();
//                     $photo_path = './public/uploads/avatar';
//                     $request->file('avatar')->move($photo_path, $photo);
//                 }

//                 $user->password = bcrypt($request->input('password'));

//                 if (!$user->save()) {
//                     return redirect()
//                         ->back()
//                         ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح .', 'type' => 'alert-danger'])
//                         ->withInput();
//                 }

//                 return redirect()->back()->with(['status' => 'success', 'message' => 'تمت العملية بنجاح ', 'type' => 'alert-success']);
//             }
//         }
//     }


//     public function updateAvatar(Request $request)
//     {
//         if ($request->isMethod('post')) {
//             $validator = Validator::make($request->all(), [
//                 'avatar' => 'required|mimes:jpeg,bmp,png'
//             ], [
//                 'avatar.required' => 'حقل :attribute حقل إجباري.',
//                 'avatar.mimes' => 'حقل :attribute حقل إجباري.',
//             ]);

//             if ($validator->fails()) {
//                 return redirect()
//                     ->back()
//                     ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية:', 'type' => 'alert-danger'])
//                     ->withErrors($validator)
//                     ->withInput();
//             } else {

//                 if ($request->file('avatar')) {
//                     $photo = time() . $request->file('avatar')->hashName();
//                     $photo_path = './public/uploads/avatar';
//                     $request->file('avatar')->move($photo_path, $photo);
//                 }

//                 $user = Auth::user();
//                 $user->avatar = $photo;

//                 if (!$user->save()) {
//                     return redirect()
//                         ->back()
//                         ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
//                         ->withInput();
//                 }

//                 return redirect()->back()->with(['status' => 'success', 'message' => 'تمت العملية بنجاح ', 'type' => 'alert-success']);
//             }
//         }
//     }

//     public function getProfile($username)
//     {
//         $user = User::where('username', $username)->first();

//         if ($user) {
//             $title = 'الحساب الشخصي للمستخدم: ' . $user->name;

//             $words_1 = Word::where('added_by', $user->id)->where('status', 1)->select(DB::raw('title as word'))->get();
//         $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 1)->select('en_past as word')->get();
//         $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 1)->select('shortcut as word')->get();
//         $slang_1 = Slang::where('added_by', $user->id)->where('status', 1)->select('sentence as word')->get();
//         $terms_1 = Medical::where('added_by', $user->id)->where('status', 1)->select('title as word')->get();
//         $formats_1 = Format::where('added_by', $user->id)->where('status', 1)->select('noun as word')->get();
//         $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 1)->select('title as word')->get();

//         //return 'aa';
//         return view('profile.content.approval', compact(['title', 'user', 'words_1', 'discharges_1', 'shortcuts_1', 'slang_1'
//             , 'terms_1', 'formats_1', 'idioms_1']));
//         } else {
//             $title =  "الصفحة غير موجودة";
//             return view('pagenotfound');
//         }
        
//     }

//     public function getProfilePending($username)
//     {
//         $user = User::where('username', $username)->first();
//         if ($user) {
//         $title = 'الحساب الشخصي للمستخدم: ' . $user->name;

//         $words_0 = Word::where('added_by', $user->id)->where('status', 0)->select(DB::raw('title as word'))->get();
//         $discharges_0 = Discharges::where('added_by', $user->id)->where('status', 0)->select('en_past as word')->get();
//         $shortcuts_0 = Shortcut::where('added_by', $user->id)->where('status', 0)->select('shortcut as word')->get();
//         $slang_0 = Slang::where('added_by', $user->id)->where('status', 0)->select('sentence as word')->get();
//         $terms_0 = Medical::where('added_by', $user->id)->where('status', 0)->select('title as word')->get();
//         $formats_0 = Format::where('added_by', $user->id)->where('status', 0)->select('noun as word')->get();
//         $idioms_0 = Idioms::where('added_by', $user->id)->where('status', 0)->select('title as word')->get();


//         //return 'aa';
//         return view('profile.content.pending', compact(['title', 'user', 'words_0', 'discharges_0', 'shortcuts_0', 'slang_0'
//             , 'terms_0', 'formats_0', 'idioms_0']));
            
//     } else {
//             $title =  "الصفحة غير موجودة";
//             return view('pagenotfound');
//         }
//     }

//     public function getProfileDecline($username)
//     {
//         $user = User::where('username', $username)->first();

//  if ($user) {
//         $title = 'الحساب الشخصي للمستخدم: ' . $user->name;


//         $words_2 = Word::where('added_by', $user->id)->where('status', 2)->select(DB::raw('title as word, note, id'))->get();
//         $discharges_2 = Discharges::where('added_by', $user->id)->where('status', 2)->select('en_past as word, note, id')->get();
//         $shortcuts_2 = Shortcut::where('added_by', $user->id)->where('status', 2)->select('shortcut as word, note, id')->get();
//         $slang_2 = Slang::where('added_by', $user->id)->where('status', 2)->select('sentence as word, note, id')->get();
//         $terms_2 = Medical::where('added_by', $user->id)->where('status', 2)->select('title as word, note, id')->get();
//         $formats_2 = Format::where('added_by', $user->id)->where('status', 2)->select('noun as word, note, id')->get();
//         $idioms_2 = Idioms::where('added_by', $user->id)->where('status', 2)->select('title as word, note, id')->get();

//         //return 'aa';
//         return view('profile.content.decline', compact(['title', 'user', 'words_2', 'discharges_2', 'shortcuts_2', 'slang_2'
//             , 'terms_2', 'formats_2', 'idioms_2']));
//  } else {
//             $title =  "الصفحة غير موجودة";
//             return view('pagenotfound');
//         }
//     }


//     public function getProfileFollowers($username)
//     {
//         $user = User::where('username', $username)->with(['followings'])->first();

//         $title = 'الحساب الشخصي للمستخدم: ' . $user->name;

//         //return $user;
//         //return 'aa';
//         return view('profile.content.followers', compact(['title', 'user']));
//     }

//     public function getProfileFollowings($username)
//     {
//         $user = User::where('username', $username)->with(['followers'])->first();

//         $title = 'الحساب الشخصي للمستخدم: ' . $user->name;


//         //return 'aa';
//         return view('profile.content.followings', compact(['title', 'user']));
//     }

//     public function followUser($username)
//     {
//         $user = User::where('username', $username)->first();
//         //return $user;
//         if (!$user) {
//             return redirect()->back()->with(['status' => 'error', 'message' => 'هذا اليوزر غير موجود']);
//         }
//         $user->followers()->attach(auth()->user()->id);
//         return redirect()->back()->with(['status' => 'success', 'message' => 'تمت المتابعة بنجاح']);
//     }

//     public function unFollowUser($username)
//     {
//         $user = User::where('username', $username)->first();
//         if (!$user) {
//             return redirect()->back()->with(['status' => 'error', 'message' => 'هذا اليوزر غير موجود']);
//         }
//         $user->followers()->detach(Auth::user()->id);
//         /* $u = Follower::where('leader_id', $user)->where('follower_id', Auth::user()->id)->first();
//          if (!$u) {
//              return redirect()->back()->with(['status' => 'error', 'message' => 'هذا اليوزر غير موجود']);
//          }
//          $u->forceDelete();*/
//         return redirect()->back()->with(['status' => 'success', 'message' => 'تم إلغاء المتابعة بنجاح']);
//     }

//     public function updateCover(Request $request)
//     {
//         if ($request->isMethod('post')) {
//             $validator = Validator::make($request->all(), [
//                 'cover' => 'required|mimes:jpeg,bmp,png'
//             ], [
//                 'cover.required' => 'حقل :attribute حقل إجباري.',
//                 'cover.mimes' => 'حقل :attribute حقل إجباري.',
//             ]);

//             if ($validator->fails()) {
//                 return redirect()
//                     ->back()
//                     ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية:', 'type' => 'alert-danger'])
//                     ->withErrors($validator)
//                     ->withInput();
//             } else {

//                 $photo = time() . $request->file('cover')->hashName();
//                 $photo_path = './public/uploads/covers';
//                 $request->file('cover')->move($photo_path, $photo);

//                 $user = Auth::user();
//                 $user->cover = $photo;

//                 if (!$user->save()) {
//                     return redirect()
//                         ->back()
//                         ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
//                         ->withInput();
//                 }

//                 return redirect()->back()->with(['status' => 'success', 'message' => 'تمت العملية بنجاح ', 'type' => 'alert-success']);
//             }
//         }
//     }

//     /**
//      * Upload Avatar
//      */

//     public function uploadAvatarForUser(Request $request)
//     {
//         $data = $_POST['image'];


//         list($type, $data) = explode(';', $data);
//         list(, $data) = explode(',', $data);


//         $data = base64_decode($data);
//         $imageName = time() . '.png';
//         file_put_contents('public/uploads/avatar/' . $imageName, $data);
//         $user = Auth::user();
//         $user->avatar = $imageName;
//         $user->save();
//     }

//     public function uploadAvatarForUserold(Request $request)
//     {
//         if (isset($_FILES['profile-pic']['name']) && !empty($_FILES['profile-pic']['name'])) {

//             if (!file_exists('images')) {
//                 mkdir('images', 0755);
//             }

//             $filename = $_FILES['profile-pic']['name'];
//             $filepath = './public/uploads/images/temp' . $filename;
//             move_uploaded_file($_FILES['profile-pic']['tmp_name'], $filepath);

//             if (!file_exists('images/crop')) {
//                 mkdir('images/crop', 0755);
//             }

//             // crop image
//             $img = Image::make($filepath);
//             $croppath = './public/uploads/avatar/' . $filename;

//             $img->crop($_POST['w'], $_POST['h'], $_POST['x1'], $_POST['y1']);
//             $img->resize(228, 228)->save($croppath);

//             $user = Auth::user();
//             $user->avatar = $filename;
//             $user->save();
//             return redirect('/' . $user->username);
//         }
//     }

//     protected function respondWithToken($token)
//     {
//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'bearer',
//             'expires_in' => auth('api')->factory()->getTTL() * 60

//         ]);
//     }

}
