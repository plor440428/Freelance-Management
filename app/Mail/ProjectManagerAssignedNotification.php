<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectManagerAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Project $project;
    public User $manager;

    public function __construct(Project $project, User $manager)
    {
        $this->project = $project;
        $this->manager = $manager;
    }

    public function build()
    {
        return $this->subject('คุณได้ถูกเพิ่มเข้าเป็นสมาชิกของทีม: ' . $this->project->name)
            ->view('emails.project_manager_assigned');
    }
}
