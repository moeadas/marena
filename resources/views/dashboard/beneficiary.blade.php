@extends('layouts.app', ['pageTitle' => 'Home'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'home'])
@endsection

@section('content')
<div class="space-y-6">
    <!-- Greeting -->
    <div>
        <h1 class="text-xl font-semibold text-marena-teal-deep">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ auth()->user()->name ?? 'there' }} 👋</h1>
        <p class="text-sm text-marena-ink-50 mt-1">Here's what's happening today.</p>
    </div>

    <!-- Today's Schedule -->
    <div>
        <x-section-header title="Today's Schedule" action-label="View all" action-route="{{ route('beneficiary.service-history') }}" />
        @if(isset($todayInterventions) && $todayInterventions->count() > 0)
            <div class="space-y-3">
                @foreach($todayInterventions as $intervention)
                    <x-intervention-card
                        :time="$intervention->scheduled_at?->format('H:i') ?? '--:--'"
                        :person="$intervention->provider?->name ?? 'Provider'"
                        :service-type="$intervention->service?->name ?? 'Service'"
                        :status="$intervention->status ?? 'scheduled'"
                        :location="$intervention->location ?? ''"
                    />
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state
                    icon="M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z;M9 22V12h6v10"
                    title="No visits scheduled today"
                    cta="Request a service"
                    cta-route="{{ route('beneficiary.request-service') }}"
                >
                    You have no appointments. Need care?
                </x-empty-state>
            </div>
        @endif
    </div>

    <!-- Alerts -->
    @if(isset($alerts) && $alerts->count() > 0)
    <div>
        <x-section-header title="Alerts" />
        <div class="space-y-2">
            @foreach($alerts->take(3) as $alert)
                <x-alert-card :severity="$alert->severity ?? 'medium'" :title="$alert->title" :time="$alert->created_at?->diffForHumans()">
                    {{ $alert->message ?? '' }}
                </x-alert-card>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Last Service -->
    @if(isset($lastService))
    <div>
        <x-section-header title="Last Service" />
        <div class="card">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-marena-sage-mist flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-sm text-marena-ink">{{ $lastService->service?->name ?? 'Service' }}</p>
                    <p class="text-xs text-marena-ink-50">{{ $lastService->provider?->name ?? '' }} &middot; {{ $lastService->completed_at?->format('M j, Y') ?? '' }}</p>
                </div>
                <x-status-badge :status="$lastService->status ?? 'completed'" />
            </div>
        </div>
    </div>
    @endif

    <!-- Messages -->
    <div>
        <x-section-header title="Messages" action-label="View all" action-route="{{ route('messages.index') }}" />
        <div class="space-y-2">
            @if(isset($conversations) && $conversations->count() > 0)
                @foreach($conversations->take(3) as $conv)
                    <x-message-thread :name="$conv->participant?->name ?? 'Unknown'" :last-message="$conv->last_message ?? ''" :time="$conv->last_message_at?->diffForHumans() ?? ''" :unread="$conv->unread_count ?? 0" />
                @endforeach
            @else
                <div class="card">
                    <x-empty-state icon="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" title="No messages yet" cta="Start a conversation" cta-route="{{ route('messages.index') }}" />
                </div>
            @endif
        </div>
    </div>

    <!-- CTA: Request Service -->
    <div class="card bg-marena-teal text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="font-medium">Need care?</p>
                <p class="text-sm text-marena-sage-light mt-0.5">Request a service in just a few taps</p>
            </div>
            <a href="{{ route('beneficiary.request-service') }}" class="bg-white text-marena-teal rounded-xl px-4 py-2.5 font-medium text-sm hover:bg-marena-cream transition-colors">Request service</a>
        </div>
    </div>
</div>
@endsection