<?php

namespace App\Http\Controllers\iPanel;

use App\Format;
use App\Log;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class FormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending($id)
    {
        // dd($id);
        Format::where('id' , $id)->update(['status'=> 1]);
        return back();
    }
    
    public function status(Request $req)
    {
        // dd($req->all());
        
        Format::where('id' ,$req->id)->update(['status'=> 3 , 'refuse' => $req->refuse]);
        return back();
    }
    public function index()
    {
        //
        $title = "إدراة شكل الكلمة";

        if (Auth::user()->roles[0]->id == 3)
            $formats = Format::where('added_by', Auth::user()->id)->orderBy('noun', 'asc')->paginate(20);
        else
            $formats = Format::orderBy('noun', 'asc')->paginate(20);

            $pending = Format::where('status' , 0)->orderBy('noun', 'asc')->paginate(5);

        if (Auth::user()->roles[0]->id == 3) { 
        return view('ipanel.format.index', compact(['title', 'formats']));
        } else {
        return view('ipanel.format.index', compact(['formats', 'title' , 'pending']));
        }

        // return view('ipanel.format.index', compact(['title', 'formats']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "إضافة جديد";
        return view('ipanel.format.create', compact(['title']));
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
                'noun' => 'required|min:1',
                'verb' => 'required|min:1',
                'adjective' => 'required|min:1',
                'adverb' => 'required|min:1',
            ], [
                'noun.required' => 'حقل الإسم إجباري',
                'verb.required' => 'حقل الفعل إجباري',
                'adjective.required' => 'حقل الصفة إجباري',
                'adverb.required' => 'حقل الحال إجباري',
                'noun.min' => 'حقل الإسم قصير جداً.',
                'verb.min' => 'حقل الإسم قصير جداً.',
                'adjective.min' => 'حقل الإسم قصير جداً.',
                'adverb.min' => 'حقل الإسم قصير جداً.',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $format = new Format();
                $format->noun = $request->input('noun');
                $format->verb = $request->input('verb');
                $format->adjective = $request->input('adjective');
                $format->adverb = $request->input('adverb');
                $format->added_by = Auth::user()->id;

                if (Auth::user()->roles[0]->id == 3)
                    $format->status = 0;
                else
                    $format->status = 1;

                if (!$format->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة شكل كلمة ' . $format->noun);
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
            $format = Format::where('added_by', Auth::user()->id)->find($id);
        else
            $format = Format::find($id);

        if (!$format || (Auth::user()->roles[0]->id == 3 && $format->status == 1)) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على الكلمة.', 'type' => 'alert-danger']);
        }
        $title = "تعديل شكل الكلمة " . $format->noun;
        return view('ipanel.format.show', compact(['title', 'format']));
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
                'noun' => 'required|min:1',
                'verb' => 'required|min:1',
                'adjective' => 'required|min:1',
                'adverb' => 'required|min:1',
            ], [
                'noun.required' => 'حقل الإسم إجباري',
                'verb.required' => 'حقل الفعل إجباري',
                'adjective.required' => 'حقل الصفة إجباري',
                'adverb.required' => 'حقل الحال إجباري',
                'noun.min' => 'حقل الإسم قصير جداً.',
                'verb.min' => 'حقل الإسم قصير جداً.',
                'adjective.min' => 'حقل الإسم قصير جداً.',
                'adverb.min' => 'حقل الإسم قصير جداً.',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $format = Format::find($id);
                $format->noun = $request->input('noun');
                $format->verb = $request->input('verb');
                $format->adjective = $request->input('adjective');
                $format->adverb = $request->input('adverb');

                $format->note = ($request->input('note')) ? $request->input('note') : null;
                if (Auth::user()->roles[0]->id == 3)
                    $format->status = 0;
                else {
                    $format->status = $request->input('status');
                    if ($request->input('status') == 1) {
                        $format->note = null;
                    }
                }

                if (!$format->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }
                $this->setLog('قام بتعديل شكل كلمة  ' . $format->noun);
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
            $format = Format::where('added_by', Auth::user()->id)->find($id);
        else
            $format = Format::find($id);

        if (!$format) {
            return redirect(route('format.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف شكل الكلمة ' . $format->noun);

        $format->forceDelete();
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
        $formats = new Format();

        if ($request->has('q')) {
            if (Auth::user()->roles[0]->id == 3) {
                $formats = $formats->where('added_by', Auth::user()->id)->where(function ($query) use ($request) {
                    $query->orwhere('noun', 'like', '%' . $request->input('q') . '%');
                    $query->orwhere('verb', 'like', '%' . $request->input('q') . '%');
                    $query->orwhere('adverb', 'like', '%' . $request->input('q') . '%');
                    $query->orwhere('adjective', 'like', '%' . $request->input('q') . '%');
                })->orderBy('noun', 'asc')->paginate(20);
            } else {
                $formats = $formats->where(function ($query) use ($request) {
                    $query->orwhere('noun', 'like', '%' . $request->input('q') . '%');
                    $query->orwhere('verb', 'like', '%' . $request->input('q') . '%');
                    $query->orwhere('adverb', 'like', '%' . $request->input('q') . '%');
                    $query->orwhere('adjective', 'like', '%' . $request->input('q') . '%');
                })->orderBy('noun', 'asc')->paginate(20);
            }
        } else {
            return redirect('format.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن الكلمة " . $request->input('q');
        $pending = Format::where('status' , 0)->orderBy('noun', 'asc')->paginate(5);
        return view('ipanel.format.index', compact(['formats', 'title','pending']));

        // return view('ipanel.format.index', compact(['formats', 'title']));

        //return 'aa';
    }


}
