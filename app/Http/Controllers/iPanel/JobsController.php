<?php

namespace App\Http\Controllers\iPanel;

use App\Job;
use App\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "إدارة الوظائف";
        $jobs = Job::orderBy('title', 'asc')->paginate(20);
        return view('ipanel.jobs.index', compact(['jobs', 'title']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "إضافة وظيفة جديدة";
        return view('ipanel.jobs.create', compact(['title']));
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
            ], [
                'title.required' => 'حقل الإسم إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $job = new Job();
                $job->title = $request->input('title');

                if (!$job->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة الوظيفة ' . $job->title);
                return redirect(url(route('jobs.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
        $job = Job::find($id);
        if (!$job) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على الكلمة.', 'type' => 'alert-danger']);
        }
        $title = "تعديل الوظيفة " . $job->title;
        return view('ipanel.jobs.show', compact(['title', 'job']));
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
            ], [
                'title.required' => 'حقل الإسم إجباري',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $job = Job::find($id);
                $job->title = $request->input('title');

                if (!$job->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل الوظيفة ' . $job->title);
                return redirect(url(route('jobs.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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

        $job = Job::find($id);
        if (!$job) {
            return redirect(route('jobs.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف الوظيفة ' . $job->title);

        $job->forceDelete();
        return redirect(route('jobs.index'))
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
        $jobs = new Job();

        if ($request->has('q')) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('q') . '%');
            })->orderBy('title', 'asc')->paginate(50);
        } else {
            return redirect('jobs.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن الكلمة " . $request->input('q');

        return view('ipanel.jobs.index', compact(['jobs', 'title']));

        //return 'aa';
    }


}
