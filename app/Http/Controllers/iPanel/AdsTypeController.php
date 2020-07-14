<?php

namespace App\Http\Controllers\iPanel;

use App\Ads;
use App\Ads_type;
use App\Log;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AdsTypeController extends Controller
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
        $types = Ads_type::paginate(20);
        return view('ipanel.adstype.index', compact('title', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "إضافة فئة جديدة";
        return view('ipanel.adstype.create', compact(['title']));
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
                'description' => 'required',

            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $adstype = new Ads_type();
                $adstype->title = $request->input('title');
                $adstype->description = $request->input('description');
                if (!$adstype->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام إضافة فئة الاعلان:  ' . $adstype->past);

                /**/
                return redirect(url(route('adstype.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
        $adstype = Ads_type::find($id);
        if (!$adstype) {
            return redirect()
                ->back()
                ->with(['message' => 'لم يتم العثور على الفئة.', 'type' => 'alert-danger']);
        }
        $title = "تعديل الفئة " . $adstype->title;
        return view('ipanel.adstype.show', compact(['title', 'adstype']));
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
                'description' => 'required',

            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $adstype = Ads_type::find($id);
                $adstype->title = $request->input('title');
                $adstype->description = $request->input('description');

                if (!$adstype->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                        ->withInput();
                }

                $this->setLog('قام بتعديل فئة الاعلان:  ' . $adstype->past);

                /**/
                return redirect(url(route('adstype.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
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
        $adstype = Ads_type::find($id);
        if (!$adstype) {
            return redirect(route('adstype.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }

        $this->setLog('قام بحذف التصريف ' . $adstype->title);

        $adstype->forceDelete();
        return redirect(route('adstype.index'))
            ->with(['message' => 'تمت العملية بنجاح.', 'type' => 'alert-success']);
    }


    public function search(Request $request)
    {
        $types = new Ads_type();

        if ($request->has('q')) {
            $types = $types->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('q') . '%');
                $query->orwhere('description', 'like', '%' . $request->input('q') . '%');
            })->orderBy('title', 'asc')->paginate(50);
        } else {
            return redirect('adstype.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');

        return view('ipanel.adstype.index', compact(['types', 'title']));

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
