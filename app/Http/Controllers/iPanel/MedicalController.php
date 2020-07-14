<?php

namespace App\Http\Controllers\iPanel;

use App\Log;
use App\Medical;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class MedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending($id)
    {
        // dd($id);
        Medical::where('id' , $id)->update(['status'=> 1]);
        return back();
    }
    
    public function status(Request $req)
    {
        // dd($req->all());
        
        Medical::where('id' ,$req->id)->update(['status'=> 3 , 'refuse' => $req->refuse]);
        return back();
    }
    public function index()
    {
        //
        if (Auth::user()->roles[0]->id == 3)
            $terms = Medical::where('added_by', Auth::user()->id)->orderBy('title', 'asc')->paginate(20);
        else
            $terms = Medical::orderBy('title', 'asc')->paginate(20);

        $title = "إدارة المصطلحات الطبية";
        $pending = Medical::where('status' , 0)->orderBy('title', 'asc')->paginate(5);

        if (Auth::user()->roles[0]->id == 3) { 
        return view('ipanel.medical.index', compact(['title', 'terms']));
        } else {
        return view('ipanel.medical.index', compact(['terms', 'title' , 'pending']));
        }

        // return view('ipanel.medical.index', compact(['terms', 'title']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "إضافة مصطلح طبي جديدة";
        return view('ipanel.medical.create', compact(['title']));
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
                'example' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
                'example.required' => 'حقل الأمثلة إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $term = new Medical();
                $term->title = $request->input('title');
                $term->translation = $request->input('translation');
                $term->example = $request->input('example');
                $term->added_by = Auth::user()->id;

                if (Auth::user()->roles[0]->id == 3)
                    $term->status = 0;
                else
                    $term->status = 1;


                if (!$term->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة المصطلح الطبي ' . $term->title);
                return redirect(url(route('medical.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
            $term = Medical::where('added_by', Auth::user()->id)->find($id);
        else
            $term = Medical::find($id);

        if (!$term) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على المصطلح.', 'type' => 'alert-danger']);
        }
        $title = "تعديل المصطلح " . $term->title;
        return view('ipanel.medical.show', compact(['title', 'term']));
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
                'example' => 'required',
            ], [
                'title.required' => 'حقل الكلمة إجباري',
                'translation.required' => 'حقل الترجمة إجباري',
                'example.required' => 'حقل الأمثلة إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $term = Medical::find($id);
                $term->title = $request->input('title');
                $term->translation = $request->input('translation');
                $term->example = $request->input('example');
                $term->note = ($request->input('note')) ? $request->input('note') : null;

                if (Auth::user()->roles[0]->id == 3)
                    $term->status = 0;
                else {
                    $term->status = $request->input('status');

                    if ($request->input('status') == 1) {
                        $term->note = null;
                    }
                }


                if (!$term->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل المصطلح الطبي ' . $term->title);
                return redirect(url(route('medical.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
            $term = Medical::where('added_by', Auth::user()->id)->find($id);
        else
            $term = Medical::find($id);


        if (!$term) {
            return redirect(route('medical.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف المصطلح ' . $term->title);

        $term->forceDelete();
        return redirect(route('medical.index'))
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
        $terms = new Medical();

        if ($request->has('q')) {
            if (Auth::user()->roles[0]->id == 3) {
                $terms = $terms->where('added_by', Auth::user()->id)->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
                })->orderBy('title', 'asc')->paginate(50);
            } else {
                $terms = $terms->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('q') . '%');
                    $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
                })->orderBy('title', 'asc')->paginate(50);
            }
        } else {
            return redirect('medical.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');
        
        $pending = Medical::where('status' , 0)->orderBy('title', 'asc')->paginate(5);
        return view('ipanel.medical.index', compact(['terms', 'title','pending']));

        // return view('ipanel.medical.index', compact(['terms', 'title']));

    }


}
