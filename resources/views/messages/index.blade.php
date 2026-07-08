@extends('layouts.app', ['pageTitle' => 'Messages'])

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Messages</h1>

    <!-- Search -->
    <div class="relative">
        <input type="text" class="input pl-10" placeholder="Search conversations...">
        <svg class="w-5 h-5 text-marena-ink-30 absolute left-3 top-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    </div>

    <!-- Conversations -->
    <div class="space-y-2">
        @if(isset($conversations) && $conversations->count() > 0)
            @foreach($conversations as $conv)
                <x-message-thread :name="$conv->name ?? 'Contact'" :last-message="$conv->last_message ?? ''" :time="$conv->time ?? ''" :unread="$conv->unread ?? 0" />
            @endforeach
        @else
            <div class="card">
                <x-empty-state icon="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" title="No conversations yet" cta="Start a conversation" cta-route="#" />
            </div>
        @endif
    </div>
</div>
@endsection