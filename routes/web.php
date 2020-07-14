<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Discharges;
use App\Format;
use App\Idioms;
use App\Mail\ContactUs;
use App\Medical;
use App\Shortcut;
use App\Slang;
use App\Word;
use Carbon\Carbon;

Auth::routes(['verify' => true]);

Route::get('clear_cache', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
});
Route::get('test', function () {
    return  Carbon::createFromDate(2018, 12, 30)->toDateString();
});
Route::get('/countdown', function () {
    return view('countdown');
});
// ->middleware('verified')
Route::group(['middleware' => ['countdown']], function () {
    #region frontend

    Route::get('/hh', 'PagesController@hh');
    Route::get('/', 'PagesController@index');
    Route::get('/index', 'PagesController@index');
    Route::get('/words', 'PagesController@words');
    Route::get('/medical', 'PagesController@medical');
    Route::get('/formats', 'PagesController@formats');
    Route::get('/discharges', 'PagesController@discharges');
    Route::get('/shortcuts', 'PagesController@Shortcuts');
    Route::get('/slang', 'PagesController@slang');
    Route::get('/idioms', 'PagesController@idioms');
    Route::get('/jobs', 'PagesController@jobs');
    Route::get('/about-moofradat', 'PagesController@about');
    Route::get('/about-us', 'PagesController@us');
    Route::get('/how-use', 'PagesController@how_use');
    Route::get('/privacy', 'PagesController@privacy');
    Route::get('/contact-us', 'PagesController@contact');
    Route::get('/terms', 'PagesController@terms');
    // Route::get('/verification-account', 'PagesController@verificationPage');


    Route::get('/search', 'PagesController@search');

    Route::get('/words/search', 'PagesController@searchWord');
    Route::get('/discharges/search', 'PagesController@searchDischarges');
    Route::get('/shortcuts/search', 'PagesController@searchShortcuts');
    Route::get('/slang/search', 'PagesController@searchSlang');
    Route::get('/medical/search', 'PagesController@searchMedical');
    Route::get('/formats/search', 'PagesController@searchFormats');
    Route::get('/idioms/search', 'PagesController@searchIdioms');


    Route::post('/sentMail', 'PagesController@sentMail');
    Route::post('/contactus', 'PagesController@sendContactUs');
    Route::post('/jobrequest', 'PagesController@sendJob');


    Route::get('/sitemap', 'SitemapController@index');


    Route::get('/forget-password', function () {
        $title = "نسيت كلمة المرور";
        return view('forget_password', compact(['title']));
    });
    Route::post('/forget-password/post', function (\Illuminate\Http\Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with(['status' => 'error', 'message' => "هناك مشكلة في عملية طلب إعادة كلمة المرور", "type" => "alert-danger"])
                ->withErrors($validator)
                ->withInput();
        }
        $user = \App\User::where('email', $request->input('email'))->first();
        if (!$user) {
            return redirect()->back()
                ->with(['status' => 'error', 'message' => "هذه البريد غير مسجل في الموقع", "type" => "alert-danger"]);
        }
        try {
            Mail::send(new \App\Mail\ForgetUserPassword($user));
            return redirect()->back()->with(['status' => 'success', 'message' => 'تم إرسال رسالتك/طلبك بنجاح', 'type' => 'alert-success']);
        } catch (Exception $exception) {
            die('die | ' . $exception->getMessage());
        }

    });


    /*Route::get('/sitemap/posts', 'SitemapController@posts');
    Route::get('/sitemap/categories', 'SitemapController@categories');
    Route::get('/sitemap/podcasts', 'SitemapController@podcasts');*/


    /*Route::get('/generatePassword', function () {
        return bcrypt('123456');
    });*/


    /**
     * Follow System
     */
    
    Route::get('/signup', function () {
        $title = "تسجيل مستخدم جديد";
        return view('register', compact(['title']));
    });
    Route::get('/login', function () {
        if (Auth::check())
            return redirect()->to('/');
        $title = "تسجيل الدخول";
        return view('login', compact(['title']));
    })->name('login');
    Route::get('/signup/success', function () {
        $title = "تم تسجيلك بنجاح";
        $message = "شكراً لك لتسجيل في موقع مفردات, رجاءاً قم بفحص بريدك للحصول على كود التفعيل.";
        // return view('front_page', compact(['title', 'content']));
        return view('verify_account', compact(['title', 'message']));
    });
    Route::get('/{username}', 'FrontAuthController@getProfile');


    // email active
    Route::get('/{username}/approval', 'FrontAuthController@getProfile');
    Route::get('/{username}/decline', 'FrontAuthController@getProfileDecline');
    Route::get('/{username}/pending', 'FrontAuthController@getProfilePending');
    Route::get('/{username}/followers', 'FrontAuthController@getProfileFollowers');
    Route::get('/{username}/followings', 'FrontAuthController@getProfileFollowings');
    Route::post('/{username}/follow', 'FrontAuthController@followUser');
    Route::post('/{username}/unfollow', 'FrontAuthController@unFollowUser');
    Route::group(['prefix' => 'user'], function () {
    Route::get('profile/settings', function () {
            $title = 'إعدادات الحساب الشخصي';
            $user = Auth::user();
            $words_1 = Word::where('added_by', $user->id)->where('status', 1)->select(DB::raw('title as word'))->get();
            $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 1)->select('en_past as word')->get();
            $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 1)->select('shortcut as word')->get();
            $slang_1 = Slang::where('added_by', $user->id)->where('status', 1)->select('sentence as word')->get();
            $terms_1 = Medical::where('added_by', $user->id)->where('status', 1)->select('title as word')->get();
            $formats_1 = Format::where('added_by', $user->id)->where('status', 1)->select('noun as word')->get();
            $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 1)->select('title as word')->get();
        
            return view('profile.edit', compact(['title', 'user', 'words_1', 'discharges_1', 'shortcuts_1', 'slang_1'
                , 'terms_1', 'formats_1', 'idioms_1']));
        });
         Route::post('profile/settings/update_info', 'FrontAuthController@updateUserInfo');
        Route::post('profile/settings/update_password', 'FrontAuthController@updatePassword');
        Route::post('profile/settings/update_avatar', 'FrontAuthController@updateAvatar');
        Route::post('profile/settings/update_cover', 'FrontAuthController@updateCover');
    });
    


    Route::group(['prefix' => 'user'], function () {
        Route::get('verify-account', function () {
            $title = "تفعيل الحساب";
            return view('verify_account', compact(['title']));
        });
        Route::get('profile/settings', function () {
            $title = 'إعدادات الحساب الشخصي';
            $user = Auth::user();
            $words_1 = Word::where('added_by', $user->id)->where('status', 1)->select(DB::raw('title as word'))->get();
            $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 1)->select('en_past as word')->get();
            $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 1)->select('shortcut as word')->get();
            $slang_1 = Slang::where('added_by', $user->id)->where('status', 1)->select('sentence as word')->get();
            $terms_1 = Medical::where('added_by', $user->id)->where('status', 1)->select('title as word')->get();
            $formats_1 = Format::where('added_by', $user->id)->where('status', 1)->select('noun as word')->get();
            $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 1)->select('title as word')->get();

            return view('profile.edit', compact(['title', 'user', 'words_1', 'discharges_1', 'shortcuts_1', 'slang_1'
                , 'terms_1', 'formats_1', 'idioms_1']));
        });
        Route::get('profile/activity/edit-req/{id}', function ($id) {
            $req = \App\Instance::where('id', $id)->first();
            $title = 'تعديل طلب إضافة كلمة : ' . $req->title;
            return view('profile_activity_edit', compact(['title', 'req']));
        });


        Route::post('register', 'UsersController@makeUser');
        Route::post('login', 'UsersController@makeLogin');
        Route::post('logout', 'Auth\UserAuthController@logoutUser');
        Route::post('verify-account', 'UsersController@checkUserCode');
        Route::get('validate-account', 'PagesController@validConfirmation');
        Route::post('validate', 'PagesController@sendvalidation');
        
        Route::post('upload_avatar', 'FrontAuthController@uploadAvatarForUser');

        Route::post('addRequest', function (\Illuminate\Http\Request $request) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:1|max:255',
                'type' => 'required|not_in:0',
                'description' => 'required|min:1',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            }

            $req = new \App\Instance();
            $req->title = $request->input('title');
            $req->type = $request->input('type');
            $req->user_id = Auth::user()->id;
            $req->description = $request->input('description');

            if (!$req->save()) {
                return redirect()
                    ->back()
                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح ', 'type' => 'alert-danger'])
                    ->withInput();
            }

            return redirect()
                ->back()
                ->with(['status' => 'success', 'message' => 'تم إضافة طلبك بنجاح, يمكنك مشاهدة طلبك في قسم قيد الإنتظار', 'type' => 'alert-success'])
                ->withInput();
        });
        
        Route::get('/profile/activity',function(){
            $title = 'إحصائيات الحساب';
            $user = Auth::user();
            $words_1 = Word::where('added_by', $user->id)->where('status', 1)->select(DB::raw('title as word'))->get();
            $words_0 = Word::where('added_by', $user->id)->where('status',0)->select(DB::raw('title as word'))->get();
            $words_2 = Word::where('added_by', $user->id)->where('status',2)->select(DB::raw('title as word'))->get();
            $discharges_1 = Discharges::where('added_by', $user->id)->where('status', 1)->select('en_past as word')->get();
            $discharges_0 = Discharges::where('added_by', $user->id)->where('status', 0)->select('en_past as word')->get();
            $discharges_2 = Discharges::where('added_by', $user->id)->where('status', 2)->select('en_past as word')->get();
            $shortcuts_1 = Shortcut::where('added_by', $user->id)->where('status', 1)->select('shortcut as word')->get();
            $shortcuts_0 = Shortcut::where('added_by', $user->id)->where('status', 0)->select('shortcut as word')->get();
            $shortcuts_2 = Shortcut::where('added_by', $user->id)->where('status', 2)->select('shortcut as word')->get();
            $slang_1 = Slang::where('added_by', $user->id)->where('status', 1)->select('sentence as word')->get();
            $slang_0 = Slang::where('added_by', $user->id)->where('status', 0)->select('sentence as word')->get();
            $slang_2 = Slang::where('added_by', $user->id)->where('status', 2)->select('sentence as word')->get();
            $terms_1 = Medical::where('added_by', $user->id)->where('status', 1)->select('title as word')->get();
            $terms_0 = Medical::where('added_by', $user->id)->where('status', 0)->select('title as word')->get();
            $terms_2 = Medical::where('added_by', $user->id)->where('status', 2)->select('title as word')->get();
            $formats_1 = Format::where('added_by', $user->id)->where('status', 1)->select('noun as word')->get();
            $formats_0 = Format::where('added_by', $user->id)->where('status',0)->select('noun as word')->get();
            $formats_2 = Format::where('added_by', $user->id)->where('status', 2)->select('noun as word')->get();
            $idioms_1 = Idioms::where('added_by', $user->id)->where('status', 1)->select('title as word')->get();
            $idioms_2 = Idioms::where('added_by', $user->id)->where('status', 2)->select('title as word')->get();
            $idioms_0 = Idioms::where('added_by', $user->id)->where('status',0)->select('title as word')->get();
        
           return view('profile_activity',compact(['title', 'user', 'words_1', 'discharges_1','discharges_0','discharges_2','words_0','words_2','shortcuts_1','shortcuts_2','shortcuts_0', 'slang_1','slang_0','slang_2','terms_2','terms_0'
                , 'terms_1', 'formats_1','formats_2','formats_0', 'idioms_1','idioms_0','idioms_2']));
        });
        Route::post('editRequest', function (\Illuminate\Http\Request $request) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:1|max:255',
                'type' => 'required|not_in:0',
                'description' => 'required|min:1',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            }

            $req = \App\Instance::find($request->input('id'));
            $req->title = $request->input('title');
            $req->type = $request->input('type');
            $req->user_id = Auth::user()->id;
            $req->description = $request->input('description');
            $req->status = 0;

            if (!$req->save()) {
                return redirect()
                    ->back()
                    ->with(['status' => 'error', 'message' => 'لم تتم العملية بنجاح ', 'type' => 'alert-danger'])
                    ->withInput();
            }

            return redirect('/user/profile/activity')
                ->with(['status' => 'success', 'message' => 'تم إضافة طلبك بنجاح, يمكنك مشاهدة طلبك في قسم قيد الإنتظار', 'type' => 'alert-success'])
                ->withInput();
        });



        Route::get('/reset-password/{hash}', function ($hash) {
            $title = "إعادة تعيين كلمة المرور";
            return view('reset-password', compact(['title', 'hash']));
        });

        Route::post('/reset-password/post', function (\Illuminate\Http\Request $request) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6|max:60',
                "re_password" => 'required|same:password',
            ], [
                'email.required' => 'حقل :attribute حقل إجباري.',
                'password.required' => 'حقل :attribute حقل إجباري.',
                're_password.required' => 'حقل :attribute حقل إجباري.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with(['status' => 'error', 'message' => "هناك مشكلة في عملية تعيين كلمة المرور", "type" => "alert-danger"])
                    ->withErrors($validator)
                    ->withInput();
            }

            if ($request->input('email') != my_crypt($request->input('hash'), 'd')) {
                return redirect()->back()
                    ->with(['status' => 'error', 'message' => "البريد الإلكتروني المدخل غير صحيح", "type" => "alert-danger"]);
            }
            $user = \App\User::where('email', $request->input('email'))->first();

            $user->password = bcrypt($request->input('password'));
            $user->save();

            return redirect('/login')
                ->with(['status' => 'success', 'message' => "تم تعيين كلمة مرور جديدة", "type" => "alert-success"]);

        });

    });

});


// Route::get('/sendNotify', 'TestController@send');

Route::get('/ipanel/verifed/{email}/{id}', 'PagesController@verifyUser');

/****************** Admin Login Page *******************/
Route::get("/ipanel/login", "iPanel\Auth\LoginController@showLoginForm")->name("ipanel.login");
Route::post("/ipanel/login", "iPanel\Auth\LoginController@login")->name("ipanel.login.submit");


Route::group(['prefix' => '/ipanel', 'middleware' => ['CheckLogin']], function () {
    //Route::get('', 'iPanel\DashboardController@home');
    Route::get('/', 'iPanel\DashboardController@home');
    Route::get('/dashboard', 'iPanel\DashboardController@home')->name('ipanel.dashboard');
    Route::post('/notice/save', 'iPanel\DashboardController@saveNotice')->name('ipanel.notice');
    Route::get('/profile', 'iPanel\DashboardController@profile');
    Route::post('/profile/update/{id}', 'iPanel\DashboardController@update');

    Route::resource('/settings', 'iPanel\SettingsController', ['only' => ['index']]);
    Route::post('/settings/update/{id}', 'iPanel\SettingsController@update');

    Route::resource('/pages', 'iPanel\PagesController', ['only' => ['index', 'show']]);
    Route::post('/pages/update/{id}', 'iPanel\PagesController@update');

    Route::get('/users/resend/{id}', 'iPanel\UsersController@RequestVerify');
    Route::resource('/users', 'iPanel\UsersController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/users/update/{id}', 'iPanel\UsersController@update');
    Route::get('/users/destroy/{id}', 'iPanel\UsersController@destroy');


    Route::resource('/roles', 'iPanel\RolesController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/roles/update/{id}', 'iPanel\RolesController@update');
    Route::post('/roles/{id}/permissions', 'iPanel\RolesController@updatePermissions');
    Route::get('/roles/destroy/{id}', 'iPanel\RolesController@destroy');


    Route::resource('/permissions', 'iPanel\PermissionsController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/permissions/update/{id}', 'iPanel\PermissionsController@update');
    Route::get('/permissions/destroy/{id}', 'iPanel\PermissionsController@destroy');


    Route::get('/words/search', 'iPanel\WordsController@search');
    Route::resource('/words', 'iPanel\WordsController', ['except' => ['update', 'destroy', 'edit']]);
    
    Route::post('/words/update/{id}', 'iPanel\WordsController@update');
    Route::get('/words/destroy/{id}', 'iPanel\WordsController@destroy');
    Route::get('/words/status/pending/{id}', 'iPanel\WordsController@pending');
    Route::post('/words/status/del', 'iPanel\WordsController@status')->name('status');


    Route::get('/discharges/search', 'iPanel\DischargesController@search');
    Route::resource('/discharges', 'iPanel\DischargesController', ['except' => ['update', 'destroy', 'edit']]);
    
    Route::get('/discharges/status/pending/{id}', 'iPanel\DischargesController@pending');
    
    Route::post('/discharges/status/del', 'iPanel\DischargesController@status')->name('discharges.status');
    
    Route::post('/discharges/update/{id}', 'iPanel\DischargesController@update');
    Route::get('/discharges/destroy/{id}', 'iPanel\DischargesController@destroy');

    Route::get('/shortcuts/search', 'iPanel\ShortcutsController@search');
    Route::resource('/shortcuts', 'iPanel\ShortcutsController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/shortcuts/update/{id}', 'iPanel\ShortcutsController@update');
    Route::get('/shortcuts/destroy/{id}', 'iPanel\ShortcutsController@destroy');
    
    Route::get('/shortcuts/status/pending/{id}', 'iPanel\ShortcutsController@pending');
    Route::post('/shortcuts/status/del', 'iPanel\ShortcutsController@status')->name('shortcuts.status');


    Route::get('/slang/search', 'iPanel\SlangController@search');
    Route::resource('/slang', 'iPanel\SlangController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/slang/update/{id}', 'iPanel\SlangController@update');
    Route::get('/slang/destroy/{id}', 'iPanel\SlangController@destroy');

    Route::get('/slang/status/pending/{id}', 'iPanel\SlangController@pending');
    Route::post('/slang/status/del', 'iPanel\SlangController@status')->name('slang.status');
    
    Route::post('/deleteSelected', 'iPanel\SlangController@deleteMany');

    Route::get('/jobs/search', 'iPanel\JobsController@search');
    Route::resource('/jobs', 'iPanel\JobsController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/jobs/update/{id}', 'iPanel\JobsController@update');
    Route::get('/jobs/destroy/{id}', 'iPanel\JobsController@destroy');


    Route::get('/medical/search', 'iPanel\MedicalController@search');
    Route::resource('/medical', 'iPanel\MedicalController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/medical/update/{id}', 'iPanel\MedicalController@update');
    Route::get('/medical/destroy/{id}', 'iPanel\MedicalController@destroy');

    Route::get('/medical/status/pending/{id}', 'iPanel\MedicalController@pending');
    Route::post('/medical/status/del', 'iPanel\MedicalController@status')->name('medical.status');
    
    Route::get('/format/search', 'iPanel\FormatController@search');
    Route::resource('/format', 'iPanel\FormatController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/format/update/{id}', 'iPanel\FormatController@update');
    Route::get('/format/destroy/{id}', 'iPanel\FormatController@destroy');

    Route::get('/format/status/pending/{id}', 'iPanel\FormatController@pending');
    Route::post('/format/status/del', 'iPanel\FormatController@status')->name('format.status');

    Route::get('/adstype/search', 'iPanel\AdsTypeController@search');
    Route::resource('/adstype', 'iPanel\AdsTypeController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/adstype/update/{id}', 'iPanel\AdsTypeController@update');
    Route::get('/adstype/destroy/{id}', 'iPanel\AdsTypeController@destroy');


    Route::get('/ads/search', 'iPanel\AdsController@search');
    Route::resource('/ads', 'iPanel\AdsController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/ads/update/{id}', 'iPanel\AdsController@update');
    Route::get('/ads/destroy/{id}', 'iPanel\AdsController@destroy');


    Route::get('/idioms/search', 'iPanel\IdiomsController@search');
    Route::resource('/idioms', 'iPanel\IdiomsController', ['except' => ['update', 'destroy', 'edit']]);
    Route::post('/idioms/update/{id}', 'iPanel\IdiomsController@update');
    Route::get('/idioms/destroy/{id}', 'iPanel\IdiomsController@destroy');

    Route::get('/idioms/status/pending/{id}', 'iPanel\IdiomsController@pending');
    Route::post('/idioms/status/del', 'iPanel\IdiomsController@status')->name('idioms.status');
    
    Route::get('/notification', 'iPanel\NotificationController@index');
    Route::post('/notification/send', 'iPanel\NotificationController@sendNotify');


    Route::resource('/help', 'iPanel\HelpController@index');
    Route::resource('/logs', 'iPanel\LogsController', ['only' => ['index']]);


    Route::get('/logout', 'iPanel\Auth\LoginController@logout')->name('ipanel.logout');
    //Password reset routes
    Route::post('/email', 'iPanel\Password\ForgotPasswordController@sendResetLinkEmail');
    Route::get('/reset/{token}', 'iPanel\Password\ResetPasswordController@showResetForm');
    Route::post('/reset', 'iPanel\Password\ResetPasswordController@reset');


    // Verify User

});




// Route::get('/home', 'HomeController@index')->name('home');
