<?php

namespace App\Mail;

use App\Models\User;
use App\Models\PaymentProof;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminSignupRequest extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public ?PaymentProof $paymentProof;

    public function __construct(User $user, ?PaymentProof $paymentProof)
    {
        $this->user = $user;
        $this->paymentProof = $paymentProof;
    }

    public function build()
    {
        return $this->subject('New signup request')
            ->view('emails.admin_signup_request');
    }
}
