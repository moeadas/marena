@extends('layouts.app', ['pageTitle' => 'My Schedule'])

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-xl font-semibold text-marena-teal-deep">My Schedule</h1>
        <p class="text-sm text-marena-ink-50 mt-1">Your daily visits and assignments.</p>
    </div>

    <!-- Date filter -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
        @for($i = 0; $i < 7; $i++)
            @php $date = now()->addDays($i); @endphp
            <a href="?date={{ $date->format('Y-m-d') }}" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm {{ request('date') === $date->format('Y-m-d') || (!request('date') && $i === 0) ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10' }}">
                <p class="font-medium">{{ $date->format('D') }}</p>
                <p class="text-xs">{{ $date->format('M j') }}</p>
            </a>
        @endfor
    </div>

    <!-- Visit List -->
    <div>
        @if(isset($visits) && $visits->count() > 0)
            <div class="space-y-3">
                @foreach($visits as $visit)
                    <x-intervention-card
                        :time="$visit->scheduled_at?->format('H:i') ?? '--:--'"
                        :person="$visit->beneficiary?->name ?? 'Beneficiary'"
                        :service-type="$visit->service?->name ?? 'Service'"
                        :status="$visit->status ?? 'scheduled'"
                        :location="$visit->location ?? ''"
                    />
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state
                    icon="M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z"
                    title="No visits scheduled"
                />
            </div>
        @endif
    </div>
</div>
@endsection