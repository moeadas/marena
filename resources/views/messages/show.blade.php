@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto px-4 py-6 flex flex-col" style="min-height: 70vh;">
    <div class="flex items-center gap-3 mb-4">
        <a href="{{ route('messages.index') }}" class="text-marena-teal">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <h1 class="text-lg font-semibold text-marena-teal-deep">{{ $conversation->subject ?? 'Conversation' }}</h1>
    </div>

    <div class="flex-1 overflow-y-auto space-y-3 mb-4">
        @foreach($conversation->messages as $msg)
        <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="{{ $msg->sender_id === auth()->id() ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink' }} rounded-2xl px-4 py-2.5 max-w-[80%] shadow-soft">
                <p class="text-xs font-medium mb-1 opacity-70">{{ $msg->sender->name }}</p>
                <p class="text-sm">{{ $msg->content }}</p>
                <p class="text-[10px] mt-1 opacity-50">{{ $msg->created_at->format('H:i') }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('messages.send', $conversation) }}" class="flex gap-2">
        @csrf
        <input type="text" name="content" placeholder="Type a message..." class="input flex-1" required>
        <button type="submit" class="btn-primary px-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </form>
</div>
@endsection