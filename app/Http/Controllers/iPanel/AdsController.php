<?php

namespace App\Http\Controllers\iPanel;

use App\Ads;
use App\Ads_type;
use App\Log;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "فئات الاعلانات";
        $ads = Ads::paginate(20);
        return view('ipanel.ads.index', compact('title', 'ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $title = "إضافة اعلان جديد";
        $types = Ads_type::all();
        return view('ipanel.ads.create', compact(['title', 'types']));


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
                'content' => 'required',
                'type' => 'required',

            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $ads = new Ads();
                $ads->content = $request->input('content');
                $ads->type_id = $request->input('type');

                if (!$ads->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة الاعلان جديد.  ');

                /**/
                return redirect(url(route('ads.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
        $ads = Ads::find($id);
        $types = Ads_type::all();
        if (!$ads) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على الفئة.', 'type' => 'alert-danger']);
        }
        $title = "تعديل اعلان ";
        return view('ipanel.ads.show', compact(['title', 'types', 'ads']));
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
                'content' => 'required',
                'type' => 'required',

            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $ads = Ads::find($id);
                $ads->content = $request->input('content');
                $ads->type_id = $request->input('type');

                if (!$ads->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل الاعلان .  ');

                /**/
                return redirect(url(route('ads.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
        $ads = Ads::find($id);
        if (!$ads) {
            return redirect(route('ads.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف اعلان ');

        $ads->forceDelete();
        return redirect(route('ads.index'))
            ->with(['message' => 'تمت العملية بنجاح.', 'type' => 'alert-success']);
    }


    public function search(Request $request)
    {
        $ads = new Ads();

        if ($request->has('q')) {
            $ads = $ads->where(function ($query) use ($request) {
                $query->where('content', 'like', '%' . $request->input('q') . '%');
            })->paginate(50);
        } else {
            return redirect('ads.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');

        return view('ipanel.ads.index', compact(['ads', 'title']));

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


}
