<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TranslationRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        return $this
            ->view('email.translationrequest', ['msg' => $request->msg_content])
            ->to(['translate@moofradat.com'])
            ->from(['sender_email' => $request->input('sender_email')],
                ['sender_name' => $request->input('sender_name')])
            ->subject('طلب ترجمة')
            ->with(['sender_name' => $request->sender_name,
                'sender_email' => $request->sender_email]);
    }
}
