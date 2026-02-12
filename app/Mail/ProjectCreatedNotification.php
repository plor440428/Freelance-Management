<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Project $project;
    public User $customer;

    public function __construct(Project $project, User $customer)
    {
        $this->project = $project;
        $this->customer = $customer;
    }

    public function build()
    {
        return $this->subject('คุณได้ถูกเพิ่มเข้าสู่โปรเจ็กต์ใหม่: ' . $this->project->name)
            ->view('emails.project_created');
    }
}
