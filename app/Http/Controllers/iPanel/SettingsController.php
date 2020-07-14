<?php

namespace App\Http\Controllers\iPanel;

use App\Log;
use App\Setting;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;


class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "إعدادت الموقع";
        $setting = Setting::find(1);
        return view('ipanel.site_settings.index', compact('title', 'setting'));

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
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'url' => 'required',
                'logo' => 'mimes:jpeg,bmp,png',
                'email' => 'required',
                'footer_text'=>'required',
                'android_app'=>'required',
                'ios_app'=>'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $setting = Setting::find($id);

                if ($request->file('logo')) {

                    $photo = time() . $request->file('logo')->hashName();
                    $photo_path = './public/uploads/images';
                    $request->file('logo')->move($photo_path, $photo);
                } else {
                    $photo = $setting->site_logo;
                }


                $setting->site_title = $request->input('title');
                $setting->site_description = $request->input('description');
                $setting->site_keywords = $request->input('keywords');
                $setting->site_logo = $photo;
                $setting->site_email = $request->input('email');
                $setting->site_url = $request->input('url');

                $setting->site_footer_text = $request->input('footer_text');
                $setting->android_app = $request->input('android_app');
                $setting->ios_app = $request->input('ios_app');

                if (!$setting->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }
                $this->setLog('قام بتعديل اعدادات الموقع');
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
