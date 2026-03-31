<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class TestComponent extends Component
{
    public $count = 0;
    public $messages = [];
    public $newMessage;
    public $projectId;

    public function mount($projectId)
    {
        $this->projectId = $projectId;
        $this->fetchMessages();
    }

    public function fetchMessages()
    {
        $this->messages = Chat::where('project_id', $this->projectId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string',
        ]);

        Chat::create([
            'project_id' => $this->projectId,
            'sender_id' => Auth::id(),
            'receiver_id' => 1, // Replace with actual receiver ID logic
            'message' => $this->newMessage,
        ]);

        $this->newMessage = '';
        $this->fetchMessages();
    }

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.test-component')
            ->layout('layouts.app'); // ถูกต้อง
    }
}
