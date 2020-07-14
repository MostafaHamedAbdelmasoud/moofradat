<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
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
use DB;
use Exception;
use Illuminate\Http\Request;
use Notification;
use Spatie\Permission\Models\Role;
use Validator;
use Image;
class FrontAuthController extends Controller
{
    // verified user
    public function __construct()
    {
        \App::setLocale('ar');
        $this->middleware(['auth','verified']);
        
    }

    public function updateUserInfo(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . Auth::user()->id,
                //'avatar' => 'mimes:jpeg,bmp,png'
            ], [
                'username.required' => 'حقل :attribute حقل إجباري.',
                'email.required' => 'حقل :attribute حقل إجباري.',
                'name.required' => 'حقل :attribute حقل إجباري.',
                'username.min' => 'حقل اسم المستخدم اقل من 5 احرف.',
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
                }

                $user = Auth::user();
                $user->email = $request->input('email');
                $user->name = $request->input('name');
                $user->bio = $request->input('bio');
                $user->location = $request->input('location');
                $user->website = $request->input('website');

                if (!$user->save()) {
                    return redirect()
                        ->back()
                        ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                return redirect()->back()->with(['status' => 'success', 'message' => 'تمت العملية بنجاح ', 'type' => 'alert-success']);
            }
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|min:5|max:50',
                'password' => 'required|confirmed|min:5|max:50',
                'avatar' => 'mimes:jpeg,bmp,png'
            ], [
                'old_password.required' => 'حقل كلمة المرور الحالية إجباري',
                'password.required' => 'حقل :attribute حقل إجباري.',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية:', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if (!\Hash::check($request->input('old_password'), $user->password)) {
                    return redirect()
                        ->back()
                        ->with(['status' => 'error', 'message' => 'كلمة المرور الحالية غير صحيح الرجاء التأكد من المدخلات', 'type' => 'alert-danger'])
                        ->withInput();
                }

                if ($request->file('avatar')) {
                    $photo = time() . $request->file('avatar')->hashName();
                    $photo_path = './public/uploads/avatar';
                    $request->file('avatar')->move($photo_path, $photo);
                }

                $user->password = bcrypt($request->input('password'));

                if (!$user->save()) {
                    return redirect()
                        ->back()
                        ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح .', 'type' => 'alert-danger'])
                        ->withInput();
                }

                return redirect()->back()->with(['status' => 'success', 'message' => 'تمت العملية بنجاح ', 'type' => 'alert-success']);
            }
        }
    }

    public function updateAvatar(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|mimes:jpeg,bmp,png'
            ], [
                'avatar.required' => 'حقل :attribute حقل إجباري.',
                'avatar.mimes' => 'حقل :attribute حقل إجباري.',
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
                }

                $user = Auth::user();
                $user->avatar = $photo;

                if (!$user->save()) {
                    return redirect()
                        ->back()
                        ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                return redirect()->back()->with(['status' => 'success', 'message' => 'تمت العملية بنجاح ', 'type' => 'alert-success']);
            }
        }
    }

    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();

        if ($user) {
            $title = 'الحساب الشخصي للمستخدم: ' . $user->name;

            $words_1 = Word::where('added_by', $user->id)->where('status', 1)->select(DB::raw('title as word'))->paginate(10);
        $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 1)->select('en_past as word')->paginate(10);
        $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 1)->select('shortcut as word')->paginate(10);
        $slang_1 = Slang::where('added_by', $user->id)->where('status', 1)->select('sentence as word')->paginate(10);
        $terms_1 = Medical::where('added_by', $user->id)->where('status', 1)->select('title as word')->paginate(10);
        $formats_1 = Format::where('added_by', $user->id)->where('status', 1)->select('noun as word')->paginate(10);
        $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 1)->select('title as word')->paginate(10);

        //return 'aa';
        return view('profile.content.approval', compact(['title', 'user', 'words_1', 'discharges_1', 'shortcuts_1', 'slang_1'
            , 'terms_1', 'formats_1', 'idioms_1']));
        } else {
            $title =  "الصفحة غير موجودة";
            return view('pagenotfound');
        }
        
    }

    public function getProfilePending($username)
    {
        $user = User::where('username', $username)->first();
        if ($user) {
        $title = 'الحساب الشخصي للمستخدم: ' . $user->name;

        $words_0 = Word::where('added_by', $user->id)->where('status', 0)->select(DB::raw('title as word'))->paginate(10);
        $discharges_0 = Discharges::where('added_by', $user->id)->where('status', 0)->select('en_past as word')->paginate(10);
        $shortcuts_0 = Shortcut::where('added_by', $user->id)->where('status', 0)->select('shortcut as word')->paginate(10);
        $slang_0 = Slang::where('added_by', $user->id)->where('status', 0)->select('sentence as word')->paginate(10);
        $terms_0 = Medical::where('added_by', $user->id)->where('status', 0)->select('title as word')->paginate(10);
        $formats_0 = Format::where('added_by', $user->id)->where('status', 0)->select('noun as word')->paginate(10);
        $idioms_0 = Idioms::where('added_by', $user->id)->where('status', 0)->select('title as word')->paginate(10);


        //return 'aa';
        return view('profile.content.pending', compact(['title', 'user', 'words_0', 'discharges_0', 'shortcuts_0', 'slang_0'
            , 'terms_0', 'formats_0', 'idioms_0']));
            
    } else {
            $title =  "الصفحة غير موجودة";
            return view('pagenotfound');
        }
    }

    public function getProfileDecline($username)
    {
        $user = User::where('username', $username)->first();

 if ($user) {
        $title = 'الحساب الشخصي للمستخدم: ' . $user->name;


        $words_2 = Word::where('added_by', $user->id)->where('status', 2)->select(DB::raw('title as word, note, id'))->paginate(10);
        $discharges_2 = Discharges::where('added_by', $user->id)->where('status', 2)->select('en_past as word, note, id')->paginate(10);
        $shortcuts_2 = Shortcut::where('added_by', $user->id)->where('status', 2)->select('shortcut as word, note, id')->paginate(10);
        $slang_2 = Slang::where('added_by', $user->id)->where('status', 2)->select('sentence as word, note, id')->paginate(10);
        $terms_2 = Medical::where('added_by', $user->id)->where('status', 2)->select('title as word, note, id')->paginate(10);
        $formats_2 = Format::where('added_by', $user->id)->where('status', 2)->select('noun as word, note, id')->paginate(10);
        $idioms_2 = Idioms::where('added_by', $user->id)->where('status', 2)->select('title as word, note, id')->paginate(10);

        //return 'aa';
        return view('profile.content.decline', compact(['title', 'user', 'words_2', 'discharges_2', 'shortcuts_2', 'slang_2'
            , 'terms_2', 'formats_2', 'idioms_2']));
 } else {
            $title =  "الصفحة غير موجودة";
            return view('pagenotfound');
        }
    }

    public function getProfileFollowers($username)
    {
        $user = User::where('username', $username)->with(['followings'])->first();

        $title = 'الحساب الشخصي للمستخدم: ' . $user->name;

        //return $user;
        //return 'aa';
        return view('profile.content.followers', compact(['title', 'user']));
    }

    public function getProfileFollowings($username)
    {
        $user = User::where('username', $username)->with(['followers'])->first();

        $title = 'الحساب الشخصي للمستخدم: ' . $user->name;


        //return 'aa';
        return view('profile.content.followings', compact(['title', 'user']));
    }

    public function followUser($username)
    {
        $user = User::where('username', $username)->first();
        //return $user;
        if (!$user) {
            return redirect()->back()->with(['status' => 'error', 'message' => 'هذا اليوزر غير موجود']);
        }
        $user->followers()->attach(auth()->user()->id);
        return redirect()->back()->with(['status' => 'success', 'message' => 'تمت المتابعة بنجاح']);
    }

    public function unFollowUser($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return redirect()->back()->with(['status' => 'error', 'message' => 'هذا اليوزر غير موجود']);
        }
        $user->followers()->detach(Auth::user()->id);
        /* $u = Follower::where('leader_id', $user)->where('follower_id', Auth::user()->id)->first();
         if (!$u) {
             return redirect()->back()->with(['status' => 'error', 'message' => 'هذا اليوزر غير موجود']);
         }
         $u->forceDelete();*/
        return redirect()->back()->with(['status' => 'success', 'message' => 'تم إلغاء المتابعة بنجاح']);
    }

    public function updateCover(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'cover' => 'required|mimes:jpeg,bmp,png'
            ], [
                'cover.required' => 'حقل :attribute حقل إجباري.',
                'cover.mimes' => 'حقل :attribute حقل إجباري.',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية:', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $photo = time() . $request->file('cover')->hashName();
                $photo_path = './public/uploads/covers';
                $request->file('cover')->move($photo_path, $photo);

                $user = Auth::user();
                $user->cover = $photo;

                if (!$user->save()) {
                    return redirect()
                        ->back()
                        ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                return redirect()->back()->with(['status' => 'success', 'message' => 'تمت العملية بنجاح ', 'type' => 'alert-success']);
            }
        }
    }

    public function uploadAvatarForUser(Request $request)
    {
        $data = $_POST['image'];


        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);


        $data = base64_decode($data);
        $imageName = time() . '.png';
        file_put_contents('public/uploads/avatar/' . $imageName, $data);
        $user = Auth::user();
        $user->avatar = $imageName;
        $user->save();
    }

    public function uploadAvatarForUserold(Request $request)
    {
        if (isset($_FILES['profile-pic']['name']) && !empty($_FILES['profile-pic']['name'])) {

            if (!file_exists('images')) {
                mkdir('images', 0755);
            }

            $filename = $_FILES['profile-pic']['name'];
            $filepath = './public/uploads/images/temp' . $filename;
            move_uploaded_file($_FILES['profile-pic']['tmp_name'], $filepath);

            if (!file_exists('images/crop')) {
                mkdir('images/crop', 0755);
            }

            // crop image
            $img = Image::make($filepath);
            $croppath = './public/uploads/avatar/' . $filename;

            $img->crop($_POST['w'], $_POST['h'], $_POST['x1'], $_POST['y1']);
            $img->resize(228, 228)->save($croppath);

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
            return redirect('/' . $user->username);
        }
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