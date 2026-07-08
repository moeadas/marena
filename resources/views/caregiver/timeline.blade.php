@extends('layouts.app', ['pageTitle' => 'Timeline'])

@section('bottom_nav')
    @include('partials.bottom-nav-caregiver', ['current' => 'timeline'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Timeline</h1>
    <p class="text-sm text-marena-ink-50 -mt-3">All interventions and events in chronological order.</p>

    <!-- Filter -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
        @foreach(['All', 'Today', 'This Week', 'This Month'] as $filter)
            <button class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium {{ $loop->first ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10' }}">{{ $filter }}</button>
        @endforeach
    </div>

    @if(isset($events) && $events->count() > 0)
        <div class="relative">
            <!-- Vertical line -->
            <div class="absolute left-4 top-0 bottom-0 w-px bg-marena-ink-10"></div>

            <div class="space-y-4">
                @foreach($events as $event)
                    <div class="relative pl-12">
                        <!-- Dot -->
                        <div class="absolute left-3 top-1 w-3 h-3 rounded-full bg-marena-teal ring-4 ring-marena-cream"></div>
                        <div class="card">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-medium text-marena-ink">{{ $event->title ?? 'Event' }}</p>
                                <span class="text-xs text-marena-ink-50">{{ $event->created_at?->format('M j, H:i') ?? '' }}</span>
                            </div>
                            <p class="text-sm text-marena-ink-50">{{ $event->description ?? '' }}</p>
                            @if($event->beneficiary ?? null)
                                <p class="text-xs text-marena-teal mt-2">👤 {{ $event->beneficiary->name ?? '' }}</p>
                            @endif
                            <div class="mt-2"><x-status-badge :status="$event->status ?? 'completed'" /></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" title="No events yet" />
        </div>
    @endif
</div>
@endsection