@extends('layouts.app', ['pageTitle' => 'Dashboard'])

@section('bottom_nav')
    @include('partials.bottom-nav-provider', ['current' => 'dashboard'])
@endsection

@section('content')
<div class="space-y-6">
    <!-- Greeting -->
    <div>
        <h1 class="text-xl font-semibold text-marena-teal-deep">Hello, {{ auth()->user()->name ?? 'Provider' }} 👋</h1>
        <p class="text-sm text-marena-ink-50 mt-1">Here's your day at a glance.</p>
    </div>

    <!-- Today's Schedule -->
    <div>
        <x-section-header title="Today's Schedule" action-label="Calendar" action-route="{{ route('provider.calendar') }}" />
        @if(isset($todaySchedule) && $todaySchedule->count() > 0)
            <div class="space-y-3">
                @foreach($todaySchedule as $intervention)
                    <x-intervention-card
                        :time="$intervention->scheduled_at?->format('H:i') ?? '--:--'"
                        :person="$intervention->beneficiary?->name ?? 'Beneficiary'"
                        :service-type="$intervention->service?->name ?? 'Service'"
                        :status="$intervention->status ?? 'scheduled'"
                        :location="$intervention->location ?? ''"
                    />
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z" title="No visits today" cta="View calendar" cta-route="{{ route('provider.calendar') }}" />
            </div>
        @endif
    </div>

    <!-- Notifications -->
    @if(isset($notifications) && $notifications->count() > 0)
    <div>
        <x-section-header title="Notifications" />
        <div class="space-y-2">
            @foreach($notifications->take(5) as $notif)
                <div class="card-tight flex items-start gap-3">
                    <div class="w-2 h-2 rounded-full bg-marena-teal mt-1.5 flex-shrink-0"></div>
                    <div class="flex-1">
                        <p class="text-sm text-marena-ink-70">{{ $notif->title ?? 'Notification' }}</p>
                        <p class="text-xs text-marena-ink-50 mt-0.5">{{ $notif->created_at?->diffForHumans() ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div>
        <x-section-header title="Quick Actions" />
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('provider.calendar') }}" class="card flex flex-col items-center gap-2 hover:bg-marena-sage-mist transition-colors">
                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <span class="text-sm font-medium text-marena-ink-70">Calendar</span>
            </a>
            <a href="{{ route('provider.beneficiaries') }}" class="card flex flex-col items-center gap-2 hover:bg-marena-sage-mist transition-colors">
                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <span class="text-sm font-medium text-marena-ink-70">Beneficiaries</span>
            </a>
            <a href="{{ route('provider.service-catalogue') }}" class="card flex flex-col items-center gap-2 hover:bg-marena-sage-mist transition-colors">
                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <span class="text-sm font-medium text-marena-ink-70">Services</span>
            </a>
            <a href="{{ route('messages.index') }}" class="card flex flex-col items-center gap-2 hover:bg-marena-sage-mist transition-colors">
                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <span class="text-sm font-medium text-marena-ink-70">Messages</span>
            </a>
        </div>
    </div>
</div>
@endsection