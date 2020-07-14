<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('v3/login', 'AuthController@login');
Route::post('v3/register', 'Api\V1\UserController@register');


    Route::get('available/{uname}', function($uname){
		$user = new App\User;
		return ["Available"=> ! $user->where('username',$uname)->count()];
	});
	Route::get('notice','Api\V1\UserController@notice');
    Route::get('words', 'Api\V1\UserController@works');
    Route::get('Idioms', 'Api\V1\UserController@Idioms');
    Route::get('Format', 'Api\V1\UserController@Format');
    Route::get('Slang', 'Api\V1\UserController@Slang');
    Route::get('Shortcut', 'Api\V1\UserController@Shortcut');
    Route::get('Medical', 'Api\V1\UserController@Medical');
    Route::get('Discharges', 'Api\V1\UserController@Discharges');
        Route::get('search', 'Api\V1\UserController@search');

        Route::get('v3/user/{username}', 'Api\V1\UserController@getProfile');

    Route::get('v3/followers/{user}', 'Api\V1\UserController@getFollowers');
    Route::get('v3/followings/{user}', 'Api\V1\UserController@getFollowings');
    
    Route::get('notice', 'Api\V1\UserController@notice');
    Route::post('forget_password/post', function (\Illuminate\Http\Request $request) {
        // return $request;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['status' => 'error', 'message' => "هناك مشكلة في عملية طلب إعادة كلمة المرور", 
                "validator"=>$validator->errors(),
                "type" => "alert-danger"]);
                
                // ->withErrors($validator)
                // ->withInput();
        }
        $user = \App\User::where('email', $request->input('email'))->first();
        if (!$user) {
            return  response()
                ->json(['status' => 'error', 'message' => "هذه البريد غير مسجل في الموقع", "type" => "alert-danger"]);
        }
        try {
            Mail::send(new \App\Mail\ForgetUserPassword($user));
            return  response()
                ->json(['status' => 'success', 'message' => 'تم إرسال رسالتك/طلبك بنجاح', 'type' => 'alert-success']);
        } catch (Exception $exception) {
            die('die | ' . $exception->getMessage());
        }

    });

Route::group([

    'middleware' => ['jwtToken'],
    'prefix' => 'v3'

], function ($router) {


    Route::post('get_verification_code','Api\V1\UserController@get_verification_code');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('words_users', 'Api\V1\UserController@words_users');
    Route::get('words_users_cansel', 'Api\V1\UserController@words_users_refuse');
    Route::get('words_users_pending', 'Api\V1\UserController@words_users_pending');
    Route::get('words_users_accepted', 'Api\V1\UserController@words_users_accepted');
    Route::post('update_info', 'Api\V1\UserController@updateInfo');
    Route::post('upload_avatar', 'Api\V1\UserController@uploadAvatar');
    Route::post('update_password', 'Api\V1\UserController@updatePassword');
    Route::get('follow/{user}', 'Api\V1\UserController@followUser');
    Route::get('unfollow/{user}', 'Api\V1\UserController@unFollowUser');
    Route::get('user_profile/{user}', 'Api\V1\UserController@getUseProfile');
    Route::post('upload_cover', 'Api\V1\UserController@uploadCover');
    
    Route::post('store_new_slang', 'Api\V1\MakeNewController@storeNewSlang');
    Route::post('store_new_word', 'Api\V1\MakeNewController@storeNewWord');
    Route::post('store_new_idioms', 'Api\V1\MakeNewController@storeNewIdioms');
    Route::post('store_new_format', 'Api\V1\MakeNewController@storeNewFormat');
    Route::post('check_code', 'Api\V1\UserController@checkVerificationCode');

    Route::post('store_new_discharges', 'Api\V1\MakeNewController@storeNewDischarges');
    Route::post('store_new_shortcuts', 'Api\V1\MakeNewController@storeNewShortcuts');
    Route::post('store_new_medical', 'Api\V1\MakeNewController@storeNewMedical');
    
    
    
    

});
