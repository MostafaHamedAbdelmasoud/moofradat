<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Verify extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->user);
        return $this
            ->view('email.Verify', ['msg' => 'تفعيل الحساب الشخصي'])
            ->from('codeverify@moofradat.com', 'Moofradat Code Verify')
            ->with(['verify_code' => $this->code])
            ->subject('تفعيل الحساب الشخصي');
    }
}
