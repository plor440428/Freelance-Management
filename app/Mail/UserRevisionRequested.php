<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRevisionRequested extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $reason;
    public string $revisionUrl;

    public function __construct(User $user, string $reason, string $revisionUrl)
    {
        $this->user = $user;
        $this->reason = $reason;
        $this->revisionUrl = $revisionUrl;
    }

    public function build()
    {
        return $this->subject('บัญชีของคุณยังไม่ผ่านการอนุมัติ กรุณาแก้ไขข้อมูล')
            ->view('emails.user_revision_requested');
    }
}
