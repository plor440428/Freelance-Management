<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetchMessages($projectId)
    {
        return Chat::where('project_id', $projectId)
                    ->with(['sender', 'receiver'])
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $validated['sender_id'] = Auth::id();

        $chat = Chat::create($validated);

        return response()->json($chat, 201);
    }
}