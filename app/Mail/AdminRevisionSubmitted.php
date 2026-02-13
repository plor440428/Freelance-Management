<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminRevisionSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $reviewUrl;

    public function __construct(User $user, string $reviewUrl)
    {
        $this->user = $user;
        $this->reviewUrl = $reviewUrl;
    }

    public function build()
    {
        return $this->subject('ผู้สมัครแก้ไขข้อมูลแล้ว รอการพิจารณาใหม่')
            ->view('emails.admin_revision_submitted');
    }
}
