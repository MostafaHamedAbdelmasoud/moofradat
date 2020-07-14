<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetUserPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        return $this
            ->view('email.forgetpass')
            ->to($this->user->email, $this->user->name)
            ->from('noreplay@moofradat.com', 'موقع مفردات')
            ->subject('إستعادة كلمة المرور - موقع مفردات')
            ->with(['user' => $this->user, 'actionUrl' => url('/user/reset-password/' . my_crypt($this->user->email))]);
    }
}
