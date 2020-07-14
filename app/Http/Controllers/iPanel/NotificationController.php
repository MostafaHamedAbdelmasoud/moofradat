<?php

namespace App\Http\Controllers\iPanel;

use App\Log;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $title = "اشعارات الهاتف";
        return view('ipanel.notification.index', compact(['title']));
    }

    public function sendNotify(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'min:2:required',
                'message' => 'min:2:required'
            ], [
                'title.required' => 'حقل العنوان إجباري',
                'title.min' => 'حقل العنوان قصير جداً',
                'message.required' => 'حقل النص إجباري',
                'message.min' => 'حقل النص قصير جداً',
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $to = 'global';
                $msg = [
                    "body" => strip_tags($request->input('message')),
                    "title" => $request->input('title'),
                    "icon" => "appicon",
                    'sound' => 'default'
                ];
                $this->sendToTopic($to, $msg);
                $this->setLog('تم إرسال إشعار بعنوان: ' . $request->title);
                return redirect()->back()->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
            }
        }
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
