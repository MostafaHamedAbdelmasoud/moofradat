<?php

namespace App\Http\Controllers\iPanel;

use App\Log;
use App\Slang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class SlangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending($id)
    {
        // dd($id);
        Slang::where('id' , $id)->update(['status'=> 1]);
        return back();
    }
    
    public function status(Request $req)
    {
        // dd($req->all());
        
        Slang::where('id' ,$req->id)->update(['status'=> 3 , 'refuse' => $req->refuse]);
        return back();
    }
    public function index()
    {
        //
        $title = "إدارة الكلمات العامية";
        if (Auth::user()->roles[0]->id == 3)
            $slang = Slang::where('added_by', Auth::user()->id)->orderBy('sentence', 'asc')->paginate(20);
        else
            $slang = Slang::where('status' ,'!=' , 0)->orderBy('id', 'desc')->paginate(20);

        $pending = Slang::where('status' , 0)->orderBy('id', 'asc')->paginate(5);

        if (Auth::user()->roles[0]->id == 3) { 
        return view('ipanel.slang.index', compact(['title', 'slang']));
        } else {
        return view('ipanel.slang.index', compact(['slang', 'title' , 'pending']));
            
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
        $title = "إضافة جملة/كلمة جديدة";
        return view('ipanel.slang.create', compact(['title']));
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
                'sentence' => 'required',
                'translation' => 'required',
            ], [
                'sentence.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $slang = new Slang();
                $slang->sentence = $request->input('sentence');
                $slang->translation = $request->input('translation');
                $slang->added_by = Auth::user()->id;

                if (Auth::user()->roles[0]->id == 3)
                    $slang->status = 0;
                else
                    $slang->status = 1;


                if (!$slang->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة الكلمة ' . $slang->sentence);

                /* Send Notification */
                $to = 'global';
                $msg = [
                    "body" => "تم إضافة كلمة: " . $request->input('sentence'),
                    "title" => "مفردات: كلمة عامية",
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
            $slang = Slang::where('added_by', Auth::user()->id)->find($id);
        else
            $slang = Slang::find($id);

        if (!$slang || (Auth::user()->roles[0]->id == 3 && $slang->status == 1)) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على الكلمة.', 'type' => 'alert-danger']);
        }
        $title = "تعديل الكلمة " . $slang->sentence;
        return view('ipanel.slang.show', compact(['title', 'slang']));

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
                'sentence' => 'required',
                'translation' => 'required',
            ], [
                'sentence.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $slang = Slang::find($id);
                $slang->sentence = $request->input('sentence');
                $slang->translation = $request->input('translation');
                $slang->note = ($request->input('note')) ? $request->input('note') : null;

                if (Auth::user()->roles[0]->id == 3)
                    $slang->status = 0;
                else {
                    $slang->status = $request->input('status');

                    if ($request->input('status') == 1) {
                        $slang->note = null;
                    }
                }

                if (!$slang->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل الكلمة ' . $slang->sentence);
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
            $slang = Slang::where('added_by')->find($id);
        else
            $slang = Slang::find($id);

        if (!$slang) {
            return redirect(route('slang.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف الكلمة ' . $slang->sentence);

        $slang->forceDelete();
        return redirect()->back()->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);


    }
    
    
    public function deleteMany(Request $request)
    {
        //
            // $deletesIds = $request->input('deletes');
            // $slang = Slang::where('id',$deletesId)->delete();
        //   $slang =  Slang::where('id' ,$deletesId)->update(['status'=> 3 , 'refuse' => $request->input('refuse') ]);
        // return back();
        
        
        $deletesId = $request->input('deletes');
        if($request->input('refuse')!=NULL){
            for ($i=0; $i<count($request->input('deletes')); $i++) {
    
                // DB::table('permission')
                $slang = Slang::where('id',$deletesId[$i])
                        ->update([
                        'status' =>3,
                        'refuse' => $request->input('refuse')[$i]
                        // 'view' => $req->view[$i],
                        // 'add' => $req->add[$i],
                        // 'edit' => $req->edit[$i],
                        // 'delete' => $req->delete[$i],
         
                ]);
        
                if (!$slang) {
                    return redirect(route('slang.index'))
                        ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
                }
            
            
            } 
        }
        else{
            for ($i=0; $i<count($request->input('deletes')); $i++) {
        
                // DB::table('permission')
                $slang = Slang::where('id',$deletesId[$i])
                        ->delete();
         
        
                if (!$slang) {
                    return redirect(route('slang.index'))
                        ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
                }
            
            
            } 
            
        }

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
        $slang = new Slang();

        if ($request->has('q')) {
            if (Auth::user()->roles[0]->id == 3) {
                $slang = $slang->where('added_by', Auth::user()->id)->where(function ($query) use ($request) {
                    $query->where('sentence', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
                })->orderBy('sentence', 'asc')->paginate(50);
            } else {
                $slang = $slang->where(function ($query) use ($request) {
                    $query->where('sentence', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
                })->orderBy('sentence', 'asc')->paginate(50);
            }
        } else {
            return redirect('slang.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن الكلمة " . $request->input('q');

            $pending = Slang::where('status' , 0)->orderBy('id', 'asc')->paginate(5);
        return view('ipanel.slang.index', compact(['slang', 'title','pending']));
        
        // return view('ipanel.slang.index', compact(['slang', 'title']));

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
