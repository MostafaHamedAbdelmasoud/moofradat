<?php

namespace App\Http\Controllers;

use App\Discharges;
use App\Format;
use App\Idioms;
use App\Job;
use App\Mail\ContactUs;
use App\Mail\validationConfirmation;
use App\Mail\Jobs;
use App\Mail\TranslationRequest;
use App\Medical;
use App\Page;
use App\Shortcut;
use App\Slang;
use App\User;
use App\Word;
use App\Notice;
use Illuminate\Http\Request;
use Mail;
use Mockery\Exception;

class PagesController extends Controller
{
    //
    public function hh () {
        $word = Discharges::get();
        $user = User::select('id')->get()->toArray();
        foreach ($word as $w) {
            $data_user_id = array_rand($user);
            $data = Discharges::find($w['id']);
            // $data->added_by = $user[$data_user_id]['id'];
            $data->added_by = 10;
            $data->save();
            // echo $user[$data_user_id]['id'] . ' ' . $w['id'] . '<br />';
        }
        // for($i=1; $i<= Word::where('added_by' , 50)->get()->count() ; $i++){



        // }
        return "done";

    }
    public function index()
    {
        $title = "الرئيسية";
        
        $notice = Notice::orderBy('created_at', 'desc')->first();

        return view('index', compact('title','notice'));
    }

    public function words()
    {
        $title = "الكلمات";
        $words = Word::where('status', 1)->orderBy('title', 'asc')->paginate(10);
        return view('words', compact('title', 'words'));
    }


    public function medical()
    {
        $title = "المصطلحات الطبية";
        $terms = Medical::where('status', 1)->orderBy('title', 'asc')->paginate(10);
        return view('medical', compact('title', 'terms'));
    }

    public function formats()
    {
        $title = "شكل الكلمة";
        $formats = Format::where('status', 1)->orderBy('noun', 'asc')->paginate(10);
        return view('formats', compact('title', 'formats'));
    }

    public function discharges()
    {
        $title = "التصريفات";
        $discharges = Discharges::where('status', 1)->orderBy('en_future', 'asc')->paginate(10);
        return view('discharges', compact('title', 'discharges'));
    }

    public function shortcuts()
    {
        $title = "الإختصارات";
        $shortcuts = Shortcut::where('status', 1)->orderBy('shortcut', 'asc')->paginate(10);
        return view('shortcuts', compact('title', 'shortcuts'));
    }

    public function slang()
    {
        $title = "الكلمات العامية";
        $slang = Slang::where('status', 1)->orderBy('sentence', 'asc')->paginate(10);
        return view('slang', compact('title', 'slang'));
    }

    public function idioms()
    {
        $title = "المصطلحات";
        $idioms = Idioms::where('status', 1)->orderBy('title', 'asc')->paginate(10);
        return view('idioms', compact('title', 'idioms'));
    }

    public function jobs()
    {
        $title = "الوظائف";
        $jobs = Job::get();
        return view('jobs', compact('title', 'jobs'));
    }

    public function about()
    {
        $title = "عن مفردات";
        $about = Page::find(3);
        return view('about', compact('title', 'about'));
    }

    public function us()
    {
        $title = "من نحن";
        $us = Page::find(1);
        return view('us', compact('title', 'us'));
    }

    public function how_use()
    {
        $title = "كيفية الاستخدام";
        $how = Page::find(2);
        return view('use', compact('title', 'how'));
    }

    public function privacy()
    {
        $title = "سياسة الخصوصية";
        $privacy = Page::find(4);
        return view('privacy', compact('title', 'privacy'));
    }

    public function contact()
    {
        $title = "إتصل بنا";
        $contact = Page::find(5);
        return view('contact', compact('title', 'contact'));
    }


    // public function verificationPage()
    // {
    //     $title = "توثيق الحساب الشخصي";
    //     //$contact = Page::find(5);
    //     return view('blue_mark_contact', compact(['title']));
    // }
    
     public function validConfirmation()
    {
        $title = "توثيق الحساب الشخصي";
        //$contact = Page::find(5);
        return view('validation', compact(['title']));
    }
    
     public function sendvalidation()
    {
        try {
            Mail::send(new validationConfirmation());
            return redirect()->back()->with(['status' => 'success', 'message' => 'تم إرسال رسالتك/طلبك بنجاح', 'type' => 'alert-success']);
        } catch (Exception $exception) {
            die('die');
        }
    }
    

    public function terms()
    {
        $title = "شروط الخدمة";
        $terms = Page::find(6);
        return view('terms', compact('title', 'terms'));
    }


    public function search(Request $request)
    {
        $words = new Word();
        $discharges = new Discharges();
        $shortcuts = new Shortcut();
        $slang = new Slang();
        $terms = new Medical();
        $formats = new Format();
        $idioms = new Idioms();

        if ($request->has('q')) {

            $words = $words->where(function ($query) use ($request) {
                $query->where('title', 'like', $request->input('q'));
                $query->orwhere('translation', 'like', '%' . $request->input('q') . '%');
            })->orderBy('title', 'asc')->get();
            $discharges = $discharges->where(function ($query) use ($request) {
                $query->where('en_past', 'like', $request->input('q'));
                $query->orwhere('en_present', 'like', $request->input('q'));
                $query->orwhere('en_future', 'like', $request->input('q') . '%');
            })->orderBy('en_future', 'asc')->get();
            $shortcuts = $shortcuts->where(function ($query) use ($request) {
                $query->where('shortcut', 'like', $request->input('q'));
                $query->orwhere('mean', 'like', $request->input('q'));
                $query->orwhere('translation', 'like', $request->input('q'));
            })->orderBy('shortcut', 'asc')->get();

            $slang = $slang->where(function ($query) use ($request) {
                $query->where('sentence', 'like', $request->input('q'));
                $query->orwhere('translation', 'like', $request->input('q'));
            })->orderBy('sentence', 'asc')->get();
            $terms = $terms->where(function ($query) use ($request) {
                $query->where('title', 'like', $request->input('q'));
                $query->orwhere('translation', 'like', $request->input('q'));
            })->orderBy('title', 'asc')->get();
            $formats = $formats->where(function ($query) use ($request) {
                $query->where('noun', 'like', $request->input('q'));
                $query->orwhere('verb', 'like', $request->input('q'));
                $query->orwhere('adjective', 'like', $request->input('q'));
                $query->orwhere('adverb', 'like', $request->input('q'));
            })->orderBy('noun', 'asc')->get();
            $idioms = $idioms->where(function ($query) use ($request) {
                $query->where('title', 'like', $request->input('q'));
            })->orderBy('title', 'asc')->get();

            $title = "عملية البحث عن : " . $request->input('q');
        }
        return view('search', compact(['title', 'words', 'discharges', 'shortcuts', 'slang', 'terms', 'formats', 'idioms']));

    }


    public function searchWord(Request $request)
    {
        $words = new Word();

        if ($request->has('q')) {
            $words = $words->where(function ($query) use ($request) {
                $query->where('title', 'like', $request->input('q'));
                $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
            })->orderBy('title', 'asc')->paginate(50);
        } else {
            return redirect('words')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');

        return view('words', compact(['words', 'title']));
    }

    public function searchDischarges(Request $request)
    {
        $discharges = new Discharges();

        if ($request->has('q')) {
            $discharges = $discharges->where(function ($query) use ($request) {
                $query->where('en_past', 'like', $request->input('q'));
                $query->orWhere('en_present', 'like', $request->input('q'));
                $query->orWhere('en_future', 'like', $request->input('q') . '%');
            })->orderBy('en_future', 'asc')->paginate(50);
        } else {
            return redirect('discharge')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');

        return view('discharges', compact(['discharges', 'title']));
    }

    public function searchShortcuts(Request $request)
    {
        $shortcuts = new Shortcut();

        if ($request->has('q')) {
            $shortcuts = $shortcuts->where(function ($query) use ($request) {
                $query->where('shortcut', 'like', '%' . $request->input('q'));
                $query->orWhere('mean', 'like', '%' . $request->input('q'));
                $query->orWhere('translation', 'like', '%' . $request->input('q'));
            })->orderBy('shortcut', 'asc')->paginate(50);
        } else {
            return redirect('shortcuts')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن الإختصار " . $request->input('q');

        return view('shortcuts', compact(['shortcuts', 'title']));
    }

    public function searchSlang(Request $request)
    {
        $slang = new Slang();

        if ($request->has('q')) {
            $slang = $slang->where(function ($query) use ($request) {
                $query->where('sentence', 'like', '%' . $request->input('q') . '%');
                $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
            })->orderBy('sentence', 'asc')->paginate(50);
        } else {
            return redirect('slang')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن الكلمة " . $request->input('q');

        return view('slang', compact(['slang', 'title']));
    }


    public function searchMedical(Request $request)
    {
        $terms = new Medical();

        if ($request->has('q')) {
            $terms = $terms->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('q') . '%');
                $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
            })->orderBy('title', 'asc')->paginate(50);
        } else {
            return redirect('medical.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');

        return view('medical', compact(['terms', 'title']));
    }


    public function searchFormats(Request $request)
    {
        $formats = new Format();

        if ($request->has('q')) {
            $formats = $formats->where(function ($query) use ($request) {
                $query->orwhere('noun', 'like', '%' . $request->input('q') . '%');
                $query->orwhere('verb', 'like', '%' . $request->input('q') . '%');
                $query->orwhere('adverb', 'like', '%' . $request->input('q') . '%');
                $query->orwhere('adjective', 'like', '%' . $request->input('q') . '%');
            })->orderBy('noun', 'asc')->paginate(20);
        } else {
            return redirect('formats.index')->with(['message' => 'لم يتم العثور على الكلمة', 'type' => 'alert-danger']);
        }
        $title = "بحث عن كلمة " . $request->input('q');

        return view('formats', compact(['formats', 'title']));
    }


    public function searchIdioms(Request $request)
    {
        $idioms = new Idioms();

        if ($request->has('q')) {
            $idioms = $idioms->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('q') . '%');
                $query->orWhere('translation', 'like', '%' . $request->input('q') . '%');
            })->orderBy('title', 'asc')->paginate(50);
        } else {
            return redirect('idioms')->with(['message' => 'لم يتم العثور على المصطلح', 'type' => 'alert-danger']);
        }
        $title = "بحث عن مصطلح " . $request->input('q');

        return view('idioms', compact(['idioms', 'title']));
    }


    public function sentMail()
    {
        try {
            Mail::send(new TranslationRequest());
            return redirect()->back();
        } catch (Exception $exception) {
            die('die');
        }
    }

    public function sendContactUs()
    {
        try {
            Mail::send(new ContactUs());
            return redirect()->back()->with(['status' => 'success', 'message' => 'تم إرسال رسالتك/طلبك بنجاح', 'type' => 'alert-success']);
        } catch (Exception $exception) {
            die('die');
        }
    }

    public function sendJob()
    {
        try {
            Mail::send(new Jobs());
            return redirect()->back();
        } catch (Exception $exception) {
            die('die');
        }
    }

    public function verifyUser($email, $id)
    {
        $user = User::where('email', $email)->first();
        if ($user->id == $id) {
            $user->verifed = 1;
            $user->save();
            return redirect(url(route('ipanel.login')))
                ->with(['message' => 'تم تفعيل حسابك. يمكنك تسجيل الدخول.', 'type' => 'alert-success']);
        } else {
            return redirect(url(route('ipanel.login')))
                ->with(['message' => 'خطأ في الرابط', 'type' => 'alert-danger']);
        }


    }


}
