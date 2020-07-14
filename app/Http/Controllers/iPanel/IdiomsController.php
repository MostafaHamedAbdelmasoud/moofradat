<?php

namespace App\Http\Controllers\iPanel;

use App\Idioms;
use App\Log;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class IdiomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
         public function pending($id)
    {
        // dd($id);
        Idioms::where('id' , $id)->update(['status'=> 1]);
        return back();
    }
    
    public function status(Request $req)
    {
        // dd($req->all());
        
        Idioms::where('id' ,$req->id)->update(['status'=> 3 , 'refuse' => $req->refuse]);
        return back();
    }
    public function index()
    {
        //
        if (Auth::user()->roles[0]->id == 3)
            $idioms = Idioms::where('added_by', Auth::user()->id)->orderBy('title', 'asc')->paginate(20);
        else
            $idioms = Idioms::orderBy('title', 'asc')->paginate(20);

        $title = "المصطلحات";

            $pending = Idioms::where('status' , 0)->orderBy('title', 'asc')->paginate(5);

        if (Auth::user()->roles[0]->id == 3) { 
        return view('ipanel.idioms.index', compact(['title', 'idioms']));
        } else {
        return view('ipanel.idioms.index', compact(['idioms', 'title' , 'pending']));
        }
        // return view('ipanel.idioms.index', compact(['idioms', 'title']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "إضافة مصطلح جديد";
        return view('ipanel.idioms.create', compact(['title']));
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
                'title' => 'required',
                'explain' => 'required',
                'translation' => 'required',
                'example' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'explain.required' => 'حقل الشرح إجباري.',
                'translation.required' => 'حقل الرجمة إجباري',
                'example.required' => 'حقل المثال إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $idioms = new Idioms();
                $idioms->title = $request->input('title');
                $idioms->explain = $request->input('explain');
                $idioms->translation = $request->input('translation');
                $idioms->example = $request->input('example');
                $idioms->added_by = Auth::user()->id;

                if (Auth::user()->roles[0]->id == 3)
                    $idioms->status = 0;
                else
                    $idioms->status = 1;


                if (!$idioms->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة مصطلح ' . $idioms->title);

                /* Send Notification */
                $to = 'global';
                $msg = [
                    "body" => "تم إضافة مصطلح: " . $request->input('title'),
                    "title" => "مفردات: مطصلح جديد",
                    "icon" => "appicon",
                    'sound' => 'default'
                ];
                $this->sendToTopic($to, $msg);
                /**/
                return redirect(url(route('idioms.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
            $idioms = Idioms::where('added_by', Auth::user()->id)->find($id);
        else
            $idioms = Idioms::find($id);

        if (!$idioms || (Auth::user()->roles[0]->id == 3 && $idioms->status == 1)) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على المصطلح.', 'type' => 'alert-danger']);
        }
        $title = "تعديل مصلطح " . $idioms->title;
        return view('ipanel.idioms.show', compact(['title', 'idioms']));
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
                'explain' => 'required',
                'translation' => 'required',
                'example' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'explain.required' => 'حقل الشرح إجباري.',
                'translation.required' => 'حقل الرجمة إجباري',
                'example.required' => 'حقل المثال إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $idioms = Idioms::find($id);
                $idioms->title = $request->input('title');
                $idioms->explain = $request->input('explain');
                $idioms->translation = $request->input('translation');
                $idioms->example = $request->input('example');

                $idioms->note = ($request->input('note')) ? $request->input('note') : null;
                if (Auth::user()->roles[0]->id == 3)
                    $idioms->status = 0;
                else {
                    $idioms->status = $request->input('status');
                    if ($request->input('status') == 1) {
                        $idioms->note = null;
                    }
                }


                if (!$idioms->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل مصطلح ' . $idioms->title);
                return redirect(url(route('idioms.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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

        $idioms = Idioms::find($id);
        if (!$idioms) {
            return redirect(route('idioms.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف مصطلح ' . $idioms->title);

        $idioms->forceDelete();
        return redirect(route('idioms.index'))
            ->with(['message' => 'تمت العملية بنجاح.', 'type' => 'alert-success']);


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
        $idioms = new Idioms();

        if ($request->has('q')) {
            $idioms = $idioms->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('q') . '%');
                $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
                $query->orWhere('explain', 'like', '%' . $request->input('q') . '%');
                $query->orWhere('example', 'like', '%' . $request->input('q') . '%');
            })->orderBy('title', 'asc')->paginate(50);
        } else {
            return redirect('idioms.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن مصطلح " . $request->input('q');
        $pending = Idioms::where('status' , 0)->orderBy('title', 'asc')->paginate(5);
        return view('ipanel.idioms.index', compact(['idioms', 'title','pending']));
        // return view('ipanel.idioms.index', compact(['idioms', 'title']));

        //return 'aa';
    }


    public function send($to, $msg)
    {
        $fields = array(
            'to' => $to,
            "notification" => $msg
        );
        /*
         *
          'to' => 'c5RSdCnbpbI:APA91bE3sATFhPsfP1tpVLo4gO8376QO6zRfWkVqltEwJwiPeBemLzDKDyc1GpxqS39ZWhWc_zSgyOzKs8WYP0RMMEoxSrLQaAST5itOF2pUbCisv7GE8JdzITeMwc3frO_ql44I-P-M',
            "notification" => [
                "body" => "Cool offers. Get them before expiring!",
                "title" => "Flat 80% discount",
                "icon" => "appicon",
                'sound' => 'default']
         *
         *
         * */
        return $this->sendNotification($fields);
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
