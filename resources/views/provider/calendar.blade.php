@extends('layouts.app', ['pageTitle' => 'Calendar'])

@section('bottom_nav')
    @include('partials.bottom-nav-provider', ['current' => 'calendar'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ view: 'week' }">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-marena-teal-deep">Calendar</h1>
        <div class="flex gap-2">
            <button @click="view = 'week'" :class="view === 'week' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'" class="px-3 py-2 rounded-lg text-sm font-medium transition-all">Week</button>
            <button @click="view = 'day'" :class="view === 'day' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'" class="px-3 py-2 rounded-lg text-sm font-medium transition-all">Day</button>
        </div>
    </div>

    <!-- Week navigation -->
    <div class="flex items-center justify-between">
        <button class="p-2 rounded-full hover:bg-marena-sage-mist">
            <svg class="w-5 h-5 text-marena-ink-50" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <span class="text-sm font-medium text-marena-ink-70">Jul 7 – Jul 13, 2025</span>
        <button class="p-2 rounded-full hover:bg-marena-sage-mist">
            <svg class="w-5 h-5 text-marena-ink-50" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
        </button>
    </div>

    <!-- Week View -->
    <div x-show="view === 'week'" class="grid grid-cols-7 gap-1">
        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
            @php $dayIndex = $loop->index; @endphp
            <div class="text-center">
                <p class="text-xs text-marena-ink-50 mb-1">{{ $day }}</p>
                <div class="bg-marena-ivory rounded-xl p-1 min-h-[120px] border border-marena-ink-10">
                    @if(isset($weekSlots[$dayIndex]))
                        @foreach($weekSlots[$dayIndex] as $slot)
                            <div class="bg-marena-teal/10 text-marena-teal text-[10px] rounded px-1 py-1 mb-1 truncate">{{ $slot['time'] }} {{ $slot['name'] }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Day View -->
    <div x-show="view === 'day'" class="space-y-2">
        @for($h = 8; $h <= 18; $h++)
            <div class="flex items-center gap-3 py-1 border-b border-marena-ink-10">
                <span class="text-xs text-marena-ink-50 w-12">{{ sprintf('%02d:00', $h) }}</span>
                <div class="flex-1 h-8"></div>
            </div>
        @endfor
    </div>

    <!-- Actions -->
    <div class="flex gap-2">
        <button class="btn-primary flex-1">+ Add Availability</button>
        <button class="btn-outline flex-1">Block Time</button>
    </div>
</div>
@endsection