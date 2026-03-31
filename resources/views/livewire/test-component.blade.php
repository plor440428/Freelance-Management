<div>
    <h1>Counter: {{  $this->count }}</h1>

    <button wire:click="increment"
        class="px-4 py-2 bg-blue-500 text-white rounded">
        เพิ่มจำนวน555
    </button>

    <!-- Chat Section -->
    <div class="chat-container border rounded p-4 mt-4">
        <h2 class="text-lg font-bold mb-2">Chat</h2>

        <!-- Messages -->
        <div class="messages h-64 overflow-y-auto border p-2 mb-4">
            @foreach($messages as $message)
                <div class="message mb-2">
                    <strong>{{ $message->sender->name }}:</strong> {{ $message->message }}
                </div>
            @endforeach
        </div>

        <!-- Send Message -->
        <form wire:submit.prevent="sendMessage">
            <div class="flex items-center">
                <input type="text" wire:model="newMessage" class="flex-1 border rounded p-2" placeholder="Type your message...">
                <button type="submit" class="ml-2 px-4 py-2 bg-green-500 text-white rounded">Send</button>
            </div>
        </form>
    </div>
</div>
