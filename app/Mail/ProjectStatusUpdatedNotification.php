<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectStatusUpdatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Project $project;
    public User $customer;
    public string $oldStatus;
    public string $newStatus;

    public function __construct(Project $project, User $customer, string $oldStatus, string $newStatus)
    {
        $this->project = $project;
        $this->customer = $customer;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function build()
    {
        return $this->subject('อัปเดตสถานะโปรเจกต์: ' . $this->project->name)
            ->view('emails.project_status_updated');
    }
}
