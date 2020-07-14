<?php

namespace App\Http\Controllers\iPanel;

use App\Discharges;
use App\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class DischargesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
         public function pending($id)
    {
        // dd($id);
        Discharges::where('id' , $id)->update(['status'=> 1]);
        return back();
    }
    
    public function status(Request $req)
    {
        // dd($req->all());
        
        Discharges::where('id' ,$req->id)->update(['status'=> 3 , 'refuse' => $req->refuse]);
        return back();
    }
    public function index()
    {
        //
        if (Auth::user()->roles[0]->id == 3) {
            $discharges = Discharges::where('added_by', Auth::user()->id)->orderBy('en_future', 'asc')->paginate(20);
        } else {
            $discharges = Discharges::where('status' ,'!=' , 0)->orderBy('en_future', 'asc')->paginate(20);
            $pending = Discharges::where('status' , 0)->orderBy('en_future', 'asc')->paginate(5);
        }

        $title = "الصطلحات";

        if (Auth::user()->roles[0]->id == 3) { 
        return view('ipanel.discharges.index', compact(['discharges', 'title' ]));
        } else {
        return view('ipanel.discharges.index', compact(['discharges', 'title' , 'pending']));
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
        $title = "إضافة تصريف جديد";
        return view('ipanel.discharges.create', compact(['title']));
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
                'en_past' => 'required',
                'en_present' => 'required',
                'en_future' => 'required',

            ], [
                'en_past.required' => 'حقل التصريف الاول إجباري',
                'en_present.required' => 'حقل التصريف الثاني إجباري',
                'en_future.required' => 'حقل التصريف الثالث إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $discharges = new Discharges();
                $discharges->en_past = $request->input('en_past');
                $discharges->ar_past = $request->input('ar_past');
                $discharges->en_present = $request->input('en_present');
                $discharges->ar_present = $request->input('ar_present');
                $discharges->en_future = $request->input('en_future');
                $discharges->ar_future = $request->input('ar_future');
                $discharges->added_by = Auth::user()->id;

                if (Auth::user()->roles[0]->id == 3)
                    $discharges->status = 0;
                else
                    $discharges->status = 1;

                if (!$discharges->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة التصريف ' . $discharges->en_past);

                /*SEND NOTIFICATION*/
                $to = 'global';
                $msg = [
                    "body" => "تم إضافة التصريف: " . $request->input('en_past'),
                    "title" => "مفردات: تصريف جديد",
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
            $discharge = Discharges::where('added_by', Auth::user()->id)->find($id);
        else
            $discharge = Discharges::find($id);

        if (!$discharge || (Auth::user()->roles[0]->id == 3 && $discharge->status == 1)) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على التصريف.', 'type' => 'alert-danger']);
        }
        $title = "تعديل التصريف " . $discharge->en_past;
        return view('ipanel.discharges.show', compact(['title', 'discharge']));
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
                'en_past' => 'required',
                'en_present' => 'required',
                'en_future' => 'required',

            ], [
                'en_past.required' => 'حقل التصريف الاول إجباري',
                'en_present.required' => 'حقل التصريف الثاني إجباري',
                'en_future.required' => 'حقل التصريف الثالث إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $discharges = Discharges::find($id);
                $discharges->en_past = $request->input('en_past');
                $discharges->ar_past = $request->input('ar_past');
                $discharges->en_present = $request->input('en_present');
                $discharges->ar_present = $request->input('ar_present');
                $discharges->en_future = $request->input('en_future');
                $discharges->ar_future = $request->input('ar_future');
                $discharges->note = ($request->input('note')) ? $request->input('note') : null;

                if (Auth::user()->roles[0]->id == 3)
                    $discharges->status = 0;
                else {
                    $discharges->status = $request->input('status');

                    if ($request->input('status') == 1) {
                        $discharges->note = null;
                    }
                }

                if (!$discharges->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل التصريف ' . $discharges->en_past);
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
            $discharge = Discharges::where('added_by', Auth::user()->id)->find($id);
        else
            $discharge = Discharges::find($id);

        if (!$discharge) {
            return redirect(route('discharges.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف التصريف ' . $discharge->en_past);

        $discharge->forceDelete();
        return redirect()->back()->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
    }


    public function search(Request $request)
    {
        $discharges = new Discharges();

        if ($request->has('q')) {
            if (Auth::user()->roles[0]->id == 3) {
                $discharges = $discharges->where('added_by', Auth::user()->id)->where(function ($query) use ($request) {
                    $query->where('en_past', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('en_present', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('en_future', 'like', '%' . $request->input('q') . '%');
                })->orderBy('en_future', 'asc')->paginate(50);
            } else {
                $discharges = $discharges->where(function ($query) use ($request) {
                    $query->where('en_past', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('en_present', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('en_future', 'like', '%' . $request->input('q') . '%');
                })->orderBy('en_future', 'asc')->paginate(50);
            }
        } else {
            return redirect('discharge.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');
            $pending = Discharges::where('status' , 0)->orderBy('en_future', 'asc')->paginate(5);
        return view('ipanel.discharges.index', compact(['discharges', 'title' ,'pending']));

        //return 'aa';
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
