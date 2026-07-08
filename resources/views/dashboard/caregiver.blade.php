@extends('layouts.app', ['pageTitle' => 'Dashboard'])

@section('bottom_nav')
    @include('partials.bottom-nav-caregiver', ['current' => 'home'])
@endsection

@section('content')
<div class="space-y-6">
    <!-- Greeting -->
    <div>
        <h1 class="text-xl font-semibold text-marena-teal-deep">Hello, {{ auth()->user()->name ?? 'Caregiver' }} 👋</h1>
        <p class="text-sm text-marena-ink-50 mt-1">Here's your coordination overview.</p>
    </div>

    <!-- Timeline Preview -->
    <div>
        <x-section-header title="Recent Timeline" action-label="View all" action-route="{{ route('caregiver.timeline') }}" />
        <div class="space-y-2">
            @if(isset($timeline) && $timeline->count() > 0)
                @foreach($timeline->take(4) as $event)
                    <div class="card-tight flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-marena-teal mt-1.5 flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-marena-ink">{{ $event->title ?? 'Event' }}</p>
                            <p class="text-xs text-marena-ink-50">{{ $event->created_at?->diffForHumans() ?? '' }}</p>
                        </div>
                        <x-status-badge :status="$event->status ?? 'completed'" />
                    </div>
                @endforeach
            @else
                <div class="card">
                    <x-empty-state icon="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" title="No recent events" cta="View timeline" cta-route="{{ route('caregiver.timeline') }}" />
                </div>
            @endif
        </div>
    </div>

    <!-- Alerts -->
    @if(isset($alerts) && $alerts->count() > 0)
    <div>
        <x-section-header title="Active Alerts" action-label="View all" action-route="{{ route('caregiver.alerts') }}" />
        <div class="space-y-2">
            @foreach($alerts->take(3) as $alert)
                <x-alert-card :severity="$alert->severity ?? 'medium'" :title="$alert->title" :time="$alert->created_at?->diffForHumans()" />
            @endforeach
        </div>
    </div>
    @endif

    <!-- Today's Schedule -->
    <div>
        <x-section-header title="Today's Schedule" />
        @if(isset($todaySchedule) && $todaySchedule->count() > 0)
            <div class="space-y-3">
                @foreach($todaySchedule as $intervention)
                    <x-intervention-card
                        :time="$intervention->scheduled_at?->format('H:i') ?? '--:--'"
                        :person="$intervention->beneficiary?->name ?? 'Beneficiary'"
                        :service-type="$intervention->service?->name ?? 'Service'"
                        :status="$intervention->status ?? 'scheduled'"
                    />
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z" title="No visits today" />
            </div>
        @endif
    </div>

    <!-- Pending Tasks -->
    @if(isset($pendingTasks) && $pendingTasks->count() > 0)
    <div>
        <x-section-header title="Pending Tasks" />
        <div class="space-y-2">
            @foreach($pendingTasks as $task)
                <div class="card-tight flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full border-2 border-marena-ink-30 flex-shrink-0"></div>
                    <span class="flex-1 text-sm text-marena-ink-70">{{ $task->title ?? 'Task' }}</span>
                    <x-status-badge :status="$task->status ?? 'pending'" />
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Care Circle Summary -->
    <div>
        <x-section-header title="Care Circle" action-label="View" action-route="{{ route('beneficiary.care-circle') }}" />
        <div class="grid grid-cols-2 gap-3">
            @if(isset($careCircle) && $careCircle->count() > 0)
                @foreach($careCircle->take(4) as $member)
                    <x-care-circle-member :name="$member->name ?? 'Member'" :role="$member->role ?? ''" :status="$member->status ?? 'active'" />
                @endforeach
            @else
                <div class="col-span-2 card">
                    <x-empty-state icon="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2;circle cx=9 cy=7 r=4" title="No care circle members" />
                </div>
            @endif
        </div>
    </div>
</div>
@endsection