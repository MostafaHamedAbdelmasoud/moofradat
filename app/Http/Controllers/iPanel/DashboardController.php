<?php

namespace App\Http\Controllers\iPanel;

use App\Discharges;
use App\Idioms;
use App\Job;
use App\Log;
use App\Medical;
use App\Shortcut;
use App\Slang;
use App\User;
use App\Notice;
use App\Word;
use App\Format;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Validator;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    //
    public function home()
    {
        //return Auth::user()->permissions;
        $logs = Log::orderBy('id', 'desc')->take(10)->get();

        $title = 'الرئيسية';
        /*if (Auth::user()->roles[0]->id == 3) {
            $words = Word::where('added_by', \Auth::user()->id)->all()->count();
            $discharges = Discharges::where('added_by', \Auth::user()->id)->all()->count();
            $shortcuts = Shortcut::where('added_by', \Auth::user()->id)->all()->count();
            $slang = Slang::where('added_by', \Auth::user()->id)->all()->count();
            $terms = Medical::where('added_by', \Auth::user()->id)->all()->count();
            //$jobs = Job::where('added_by', Auth::user()->id)->all()->count();
            $formats = Format::where('added_by', \Auth::user()->id)->all()->count();
            $idioms = Idioms::where('added_by', \Auth::user()->id)->all()->count();
        } else {

        }*/
        $notice = Storage::get('notice.txt');

        if (\Auth::user()->roles[0]->id == 3) {

            $words = Word::where('added_by', \Auth::user()->id)->get()->count();
            $discharges = Discharges::where('added_by', \Auth::user()->id)->get()->count();
            $shortcuts = Shortcut::where('added_by', \Auth::user()->id)->get()->count();
            $slang = Slang::where('added_by', \Auth::user()->id)->get()->count();
            $terms = Medical::where('added_by', \Auth::user()->id)->get()->count();
            $formats = Format::where('added_by', \Auth::user()->id)->get()->count();
            $idioms = Idioms::where('added_by', \Auth::user()->id)->get()->count();

            return view('ipanel.dashboard', compact(['title', 'words', 'discharges', 'shortcuts', 'slang', 'terms', 'formats', 'idioms','notice']));
        } else {
            $words = Word::all()->count();
            $discharges = Discharges::all()->count();
            $shortcuts = Shortcut::all()->count();
            $slang = Slang::all()->count();
            $terms = Medical::all()->count();
            $jobs = Job::all()->count();
            $formats = Format::all()->count();
            $idioms = Idioms::all()->count();

            return view('ipanel.dashboard', compact(['title', 'logs', 'words', 'discharges', 'shortcuts', 'slang', 'terms', 'jobs', 'formats', 'idioms','notice']));
        }


    }

    public function profile()
    {
        $user = Auth::user();
        $roles = Role::all();
        $title = "الصفحة الشخصية للمستخدم " . $user->name;
        return view('ipanel.profile', compact(['title', 'user', 'roles']));
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
                    'password' => 'max:60',
                    "re_password" => 'same:password',
                    'avatar' => 'mimes:jpeg,bmp,png'
                ], [
                    'username.required' => 'حقل :attribute حقل إجباري.',
                    'email.required' => 'حقل :attribute حقل إجباري.',
                    'full_name.required' => 'حقل :attribute حقل إجباري.',
                    // 'username.min' => 'حقل اسم المستخدم اقل من 5 احرف.',
                    // 'password.min' => 'حقل كلمة المرور اقل من 6 احرف.',
                    're_password.same' => 'تأكد من تطابق كلمتي المرور المدخلات.'
                ]);
                $user->password = bcrypt($request->input('password'));
            } else {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|min:5|max:50|unique:users,username,' . $id,
                    'full_name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'avatar' => 'mimes:jpeg,bmp,png'
                ], [
                    'username.required' => 'حقل :attribute حقل إجباري.',
                    'email.required' => 'حقل :attribute حقل إجباري.',
                    'full_name.required' => 'حقل :attribute حقل إجباري.',
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
                $this->setLog('قام بتعديل صفحته الشخصية ' . $user->name);
                return redirect(url("/ipanel/profile"))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
            }
        }


    }
	
	//save notice
	public function saveNotice(Request $request){
	   // Storage::put('notice.txt', $request->notification);
	    $notice = new Notice();
	    
	    $notice->notice_desc = $request->editordata;
	    
	    Storage::disk('local')->put('notice.txt', $request->editordata2 );
	   // $message = "حدث خطأ ما";
	   // $notice-save();
	    if (!$notice->save()) {
            return redirect()->back()->with(['message' => 'لم يتم تسجيل العملية', 'type' => 'alert-danger']);
        }
		return redirect(route("ipanel.dashboard"));
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
