<?php

namespace App\Http\Controllers\iPanel;

use App\Log;
use App\Word;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class WordsController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending($id)
    {
        // dd($id);
        Word::where('id' , $id)->update(['status'=> 1]);
        return back();
    }
    
    public function status(Request $req)
    {
        // dd($req->all());
        
        Word::where('id' ,$req->id)->update(['status'=> 3 , 'refuse' => $req->refuse]);
        return back();
    }
    public function index()
    {
        //
        if (Auth::user()->roles[0]->id == 3) {
            $words = Word::where('added_by', Auth::user()->id)->orderBy('title', 'asc')->paginate(20);
         } else {
            $words = Word::where('status' ,'!=' , 0)->orderBy('title', 'asc')->paginate(20);
            $pending = Word::where('status' , 0)->orderBy('title', 'asc')->paginate(5);
         }

        $title = "المفردات";

        // dd($words);
        if (Auth::user()->roles[0]->id == 3) { 
        return view('ipanel.words.index', compact(['words', 'title' ]));
        } else {
        return view('ipanel.words.index', compact(['words', 'title' , 'pending']));
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
        $title = "إضافة مفردات جديدة";
        return view('ipanel.words.create', compact(['title']));
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
                'translation' => 'required',
                'definition' => 'required',
                'examples' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
                'definition.required' => 'حقل التعريف إجباري',
                'examples.required' => 'حقل الأمثلة إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $word = new Word();
                $word->title = $request->input('title');
                $word->translation = $request->input('translation');
                $word->definition = $request->input('definition');
                $word->examples = $request->input('examples');
                $word->added_by = Auth::user()->id;
                if (Auth::user()->roles[0]->id == 3)
                    $word->status = 0;
                else
                    $word->status = 1;

                if (!$word->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة الكلمة ' . $word->title);

                /* Send Notification */
                $to = 'global';
                $msg = [
                    "body" => "تم إضافة كلمة: " . $request->input('title'),
                    "title" => "مفردات: كلمة جديدة",
                    "icon" => "appicon",
                    'sound' => 'default'
                ];
                $this->sendToTopic($to, $msg);
                /**/
                //return redirect(url(route('words.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
            $word = Word::where('added_by', Auth::user()->id)->find($id);
        else
            $word = Word::find($id);

        if (!$word || (Auth::user()->roles[0]->id == 3 && $word->status == 1)) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على الكلمة.', 'type' => 'alert-danger']);
        }
        $title = "تعديل الكلمة " . $word->title;
        return view('ipanel.words.show', compact(['title', 'word']));
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
                'translation' => 'required',
                'definition' => 'required',
                'examples' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
                'definition.required' => 'حقل التعريف إجباري',
                'examples.required' => 'حقل الأمثلة إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $word = Word::find($id);
                $word->title = $request->input('title');
                $word->translation = $request->input('translation');
                $word->definition = $request->input('definition');
                $word->examples = $request->input('examples');
                $word->note = ($request->input('note')) ? $request->input('note') : null;

                if (Auth::user()->roles[0]->id == 3)
                    $word->status = 0;
                else {
                    $word->status = $request->input('status');

                    if ($request->input('status') == 1) {
                        $word->note = null;
                    }
                }


                if (!$word->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل الكلمة ' . $word->title);
                //return redirect(url(route('words.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
            $word = Word::where('added_by', Auth::user()->id)->find($id);
        else
            $word = Word::find($id);

        if (!$word) {
            return redirect(route('words.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف الكلمة ' . $word->title);

        $word->forceDelete();
        return redirect()->back()
            ->with(['message' => 'تمت العملية بنجاح.', 'type' => 'alert-success']);
    }

    private
    function setLog($msg)
    {
        $user = Auth::user();
        $log = New Log();
        $log->user_id = $user->id;
        $log->log_message = $msg;
        if (!$log->save()) {
            return redirect()->back()->with(['message' => 'لم يتم تسجيل العملية', 'type' => 'alert-danger']);
        }
    }

    public
    function search(Request $request)
    {
        $words = new Word();

        if ($request->has('q')) {
            if (Auth::user()->roles[0]->id == 3) {
                $words = $words->where('added_by', Auth::user()->id)->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
                })->orderBy('title', 'asc')->paginate(50);
            } else {
                $words = $words->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
                })->orderBy('title', 'asc')->paginate(50);
            }

        } else {
            return redirect('words.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');
            $pending = Word::where('status' , 0)->orderBy('title', 'asc')->paginate(5);
        return view('ipanel.words.index', compact(['words', 'title','pending']));

        //return 'aa';
    }

    public
    function send($to, $msg)
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
    public
    function sendToTopic($to, $message)
    {
        $fields = array(
            'to' => '/topics/' . $to,
            'notification' => $message,
        );
        return $this->sendNotification($fields);
    }


    //
    public
    function sendNotification($fields)
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
