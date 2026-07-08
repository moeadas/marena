<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $conversations = Conversation::whereJsonContains('participants', $userId)
            ->with(['messages' => fn($q) => $q->latest()->limit(1)])
            ->orderByDesc('last_message_at')
            ->paginate(20);
        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $conversation->load(['messages.sender', 'participants']);
        // Mark messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        return view('messages.show', compact('conversation'));
    }

    public function send(Request $request, Conversation $conversation)
    {
        $validated = $request->validate(['content' => 'required|string']);
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => $validated['content'],
        ]);
        $conversation->update(['last_message_at' => now()]);
        return back();
    }

    public function newConversation(Request $request)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:users,id',
            'subject' => 'nullable|string',
            'content' => 'required|string',
        ]);

        $participants = [Auth::id(), $validated['participant_id']];
        $conversation = Conversation::create([
            'subject' => $validated['subject'] ?? null,
            'type' => 'direct',
            'participants' => $participants,
            'last_message_at' => now(),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('messages.show', $conversation)->with('success', 'Conversation started.');
    }
}