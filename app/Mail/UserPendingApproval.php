<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPendingApproval extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('ลงทะเบียนสำเร็จ: รอแอดมินอนุมัติบัญชี')
            ->view('emails.user_pending_approval');
    }
}
