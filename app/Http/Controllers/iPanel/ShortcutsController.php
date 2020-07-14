<?php

namespace App\Http\Controllers\iPanel;

use App\Log;
use App\Shortcut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class ShortcutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending($id)
    {
        // dd($id);
        Shortcut::where('id' , $id)->update(['status'=> 1]);
        return back();
    }
    
    public function status(Request $req)
    {
        // dd($req->all());
        
        Shortcut::where('id' ,$req->id)->update(['status'=> 3 , 'refuse' => $req->refuse]);
        return back();
    }

    public function index()
    {
        //
        $title = "إدارة الاختصارت";
        if (Auth::user()->roles[0]->id == 3)
            $shortcuts = Shortcut::where('added_by', Auth::user()->id)->orderBy('shortcut', 'asc')->paginate(20);
        else
            $shortcuts = Shortcut::where('status' ,'!=' , 0)->orderBy('shortcut', 'asc')->paginate(20);
            $pending = Shortcut::where('status' , 0)->orderBy('shortcut', 'asc')->paginate(5);

        if (Auth::user()->roles[0]->id == 3) { 
        return view('ipanel.shortcuts.index', compact(['title', 'shortcuts']));
        } else {
        return view('ipanel.shortcuts.index', compact(['shortcuts', 'title' , 'pending']));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "إضافة إختصار جديد";
        return view('ipanel.shortcuts.create', compact(['title']));
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
                'shortcut' => 'required',
                'mean' => 'required',
                'translation' => 'required',
            ], [
                'shortcut.required' => 'حقل الإختصار إجباري',
                'mean.required' => 'حقل الإختصار كامل إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $shortcut = new Shortcut();
                $shortcut->shortcut = $request->input('shortcut');
                $shortcut->mean = $request->input('mean');
                $shortcut->translation = $request->input('translation');
                $shortcut->added_by = Auth::user()->id;

                if (Auth::user()->roles[0]->id == 3)
                    $shortcut->status = 0;
                else
                    $shortcut->status = 1;


                if (!$shortcut->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة الإختصار ' . $shortcut->shortcut);

                /* Send Notification */
                $to = 'global';
                $msg = [
                    "body" => "تم إضافة الإختصار: " . $request->input('shortcut'),
                    "title" => "مفردات: الإخصتارات",
                    "icon" => "appicon",
                    'sound' => 'default'
                ];
                $this->sendToTopic($to, $msg);
                /**/


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
        if (Auth::user()->roles[0]->id == 3)
            $shortcut = Shortcut::where('added_by', Auth::user()->id)->find($id);
        else
            $shortcut = Shortcut::find($id);

        if (!$shortcut) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على الكلمة.', 'type' => 'alert-danger']);
        }
        $title = "تعديل الإختصار " . $shortcut->shortcut;
        return view('ipanel.shortcuts.show', compact(['title', 'shortcut']));
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
                'shortcut' => 'required',
                'mean' => 'required',
                'translation' => 'required',
            ], [
                'shortcut.required' => 'حقل الإختصار إجباري',
                'mean.required' => 'حقل الإختصار كامل إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $shortcut = Shortcut::find($id);
                $shortcut->shortcut = $request->input('shortcut');
                $shortcut->mean = $request->input('mean');
                $shortcut->translation = $request->input('translation');
                $shortcut->note = ($request->input('note')) ? $request->input('note') : null;

                if (Auth::user()->roles[0]->id == 3)
                    $shortcut->status = 0;
                else {
                    $shortcut->status = $request->input('status');
                    if ($request->input('status') == 1) {
                        $shortcut->note = null;
                    }
                }

                if (!$shortcut->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل الإختصار ' . $shortcut->shortcut);
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
        if (Auth::user()->roles[0]->id == 3)
            $shortcut = Shortcut::where('added_by', Auth::user()->id)->find($id);
        else
            $shortcut = Shortcut::find($id);

        if (!$shortcut) {
            return redirect(route('shortcuts.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف الإختصار ' . $shortcut->shortcut);

        $shortcut->forceDelete();
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

    public function search(Request $request)
    {
        $shortcuts = new Shortcut();

        if ($request->has('q')) {
            $shortcuts = $shortcuts->where(function ($query) use ($request) {
                $query->where('shortcut', 'like', '%' . $request->input('q') . '%');
                $query->orWhere('mean', 'like', '%' . $request->input('q') . '%');
                $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
            })->orderBy('shortcut', 'asc')->paginate(50);
        } else {
            return redirect('shortcuts.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن الإختصار " . $request->input('q');

        $pending = Shortcut::where('status' , 0)->orderBy('shortcut', 'asc')->paginate(5);
        return view('ipanel.shortcuts.index', compact(['shortcuts', 'title','pending']));
        // return view('ipanel.shortcuts.index', compact(['shortcuts', 'title']));

        //return 'aa';
    }


    // Sending message to a topic by topic name
    public function sendToTopic($to, $message)
    {
        $fields = array(
            'to' => '/topics/' . $to,
            'notification' => $message,
        );
        return $this->sendNotification($fields);
    }


    //
    public function sendNotification($fields)
    {
        $firebase_url = "https://fcm.googleapis.com/fcm/send";
        $headers = array(
            'Authorization: key=' . env('FIREBASE_API_KEY'),
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $firebase_url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        //return true;
    }


}
