@extends('layouts.app', ['pageTitle' => 'Messaging Oversight'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'messages'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ tab: 'broadcasts' }">
    <h1 class="text-2xl font-semibold text-marena-teal-deep">Messaging Oversight</h1>

    <!-- Tabs -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
        @php
            $tabs = [
                ['key' => 'broadcasts', 'label' => 'Broadcasts'],
                ['key' => 'reminders', 'label' => 'Automated Reminders'],
                ['key' => 'tickets', 'label' => 'Support Tickets'],
            ];
        @endphp
        @foreach($tabs as $tab)
            <button @click="tab = '{{ $tab['key'] }}'" :class="tab === '{{ $tab['key'] }}' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all">{{ $tab['label'] }}</button>
        @endforeach
    </div>

    <!-- Broadcasts -->
    <div x-show="tab === 'broadcasts'" x-transition class="space-y-4">
        <button class="btn-primary w-full">+ New Broadcast</button>
        @if(isset($broadcasts) && $broadcasts->count() > 0)
            <div class="space-y-3">
                @foreach($broadcasts as $broadcast)
                    <div class="card">
                        <p class="font-medium text-sm text-marena-ink">{{ $broadcast->title ?? 'Broadcast' }}</p>
                        <p class="text-sm text-marena-ink-50 mt-1">{{ $broadcast->message ?? '' }}</p>
                        <p class="text-xs text-marena-ink-50 mt-2">Sent to: {{ $broadcast->audience ?? 'All users' }} &middot; {{ $broadcast->created_at?->diffForHumans() ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" title="No broadcasts" cta="Create broadcast" cta-route="#" />
            </div>
        @endif
    </div>

    <!-- Automated Reminders -->
    <div x-show="tab === 'reminders'" x-transition class="space-y-3">
        @foreach(['Appointment reminders', 'Medication reminders', 'Follow-up reminders'] as $reminder)
            <div class="card flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-marena-ink">{{ $reminder }}</p>
                    <p class="text-xs text-marena-ink-50">Sent automatically</p>
                </div>
                <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
            </div>
        @endforeach
    </div>

    <!-- Support Tickets -->
    <div x-show="tab === 'tickets'" x-transition>
        @if(isset($tickets) && $tickets->count() > 0)
            <div class="space-y-3">
                @foreach($tickets as $ticket)
                    <div class="card flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-marena-ink truncate">{{ $ticket->subject ?? 'Ticket' }}</p>
                            <p class="text-xs text-marena-ink-50">From: {{ $ticket->user ?? 'Unknown' }} &middot; {{ $ticket->created_at?->diffForHumans() ?? '' }}</p>
                        </div>
                        <x-status-badge :status="$ticket->status ?? 'pending'" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" title="No support tickets" />
            </div>
        @endif
    </div>
</div>
@endsection