<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Discharges;
use App\Word;

$app->get('/', function () use ($app) {
    return redirect('/v2');
});


$app->group(['prefix' => '/v1', 'namespace' => 'App\Http\Controllers'], function () use ($app) {

    $app->get('/', function () use ($app) {
        /*return $app->version();*/
        /*$Vocab = Vocabulary::get();
        $countVocab = count($Vocab);
        $Disch = Discharges::get();
        $countDisch = count($Disch);
        $response = ['status' => true, 'message' => 'welcome to moofradat.com Api. by iFeras93', 'request' => 'Index', 'result' =>
            ['vocabularies' => $countVocab, 'discharges' => $countDisch]];
        return response()->json($response);*/

        $response = [
            'title' => 'Welcome to moofradat.com Api. by iFeras93',
            'message' => 'We Are Upgrade To API Version 2',
            'link' => env('APP_URL')
        ];
        return response()->json($response);
    });

    /*$app->get('/words', 'ApiController@words');
    $app->get('/discharges', 'ApiController@discharges');

    $app->get('/word/{id}', 'ApiController@wordById');
    $app->get('/discharge/{id}', 'ApiController@dischargeByID');
    $app->get('/message/{subject}/{content}/{from}', 'ApiController@sendMsg');*/
});

// uhxrbvbxksnqtckp

$app->group(['prefix' => '/v2'], function () use ($app) {
    $app->get('/', function () {

        $links = [
            '/Words' => url('v2/words'),
            '/Discharges' => url('v2/discharges'),
            '/Slang' => url('v2/slang'),
            '/Shortcuts' => url('v2/shortcuts'),
            '/Medical' => url('v2/medical'),
            '/Formats' => url('v2/formats'),
            '/Idioms' => url('v2/idioms'),
            '/Jobs' => url('v2/jobs'),
            '/ads' => url('v2/ads'),
            '/sendEmail' => null,
            '/translateRequest' => null,
            '/jobRequest' => null
        ];
        $response = [
            'message' => 'Welcome to moofradat.com Api Version 2. by iFeras93',
            'request' => 'Home',
            'result' => $links
        ];
        return response()->json($response);
    });

    $app->get('/words', 'ApiController@Words');
    $app->get('/discharges', 'ApiController@Discharges');
    $app->get('/medical', 'ApiController@Medical');
    $app->get('/slang', 'ApiController@Slang');
    $app->get('/shortcuts', 'ApiController@shortCuts');
    $app->get('/jobs', 'ApiController@Jobs');
    $app->get('/formats', 'ApiController@Formats');
    $app->get('/idioms', 'ApiController@Idioms');
    $app->get('/all', 'ApiController@all');
    $app->get('/ads', 'ApiController@Ads');


    $app->get('/words/{id}', 'ApiController@wordById');
    $app->get('/discharges/{id}', 'ApiController@dischargesById');
    $app->get('/medical/{id}', 'ApiController@medicalById');
    $app->get('/slang/{id}', 'ApiController@slangById');
    $app->get('/shortcuts/{id}', 'ApiController@shortutsById');
    //$app->get('/jobs/{id}', 'ApiController@Jobs');
    $app->get('/formats/{id}', 'ApiController@formatsById');


    $app->get('/message/{subject}/{content}/{from}', 'ApiController@sendMsg');
    $app->post('/sendEmail', 'ApiController@sendEmail');
    $app->post('/translateRequest', 'ApiController@translateRequest');
    $app->post('/jobRequest', 'ApiController@jobRequest');


    /**
     * User Auth Routes
     */

    $app->get('user/test', 'UserController@test');

    $app->post('user/login', 'UserController@login');
    /* $app->post('user/register', 'UserController@');
     $app->post('user/verify', 'UserController@');*/
    $app->post('user/follow', 'UserController@followUser');
    $app->post('user/unfollow', 'UserController@unFollowUser');
});


