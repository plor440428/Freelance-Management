<?php

namespace App\Mail;

use App\Models\User;
use App\Models\PaymentProof;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserApproved extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public ?PaymentProof $paymentProof;
    public ?User $approver;

    public function __construct(User $user, ?PaymentProof $paymentProof, ?User $approver)
    {
        $this->user = $user;
        $this->paymentProof = $paymentProof;
        $this->approver = $approver;
    }

    public function build()
    {
        return $this->subject('บัญชีของคุณได้รับการอนุมัติแล้ว')
            ->view('emails.user_approved');
    }
}
