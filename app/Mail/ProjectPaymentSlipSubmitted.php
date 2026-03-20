<?php

namespace App\Mail;

use App\Models\ProjectPaymentProof;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectPaymentSlipSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public ProjectPaymentProof $payment;

    public function __construct(ProjectPaymentProof $payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        $projectName = $this->payment->project?->name ?? 'Unknown Project';

        return $this->subject('มีการส่งสลิปชำระเงินโปรเจ็ค: ' . $projectName)
            ->view('emails.project_payment_slip_submitted');
    }
}
