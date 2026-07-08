@extends('layouts.app', ['pageTitle' => 'Reminders'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'home'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Reminders</h1>

    <!-- Filter tabs -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
        <button class="flex-shrink-0 px-4 py-2 rounded-xl bg-marena-teal text-white text-sm font-medium">All</button>
        <button class="flex-shrink-0 px-4 py-2 rounded-xl bg-marena-ivory text-marena-ink-50 border border-marena-ink-10 text-sm">Medication</button>
        <button class="flex-shrink-0 px-4 py-2 rounded-xl bg-marena-ivory text-marena-ink-50 border border-marena-ink-10 text-sm">Appointments</button>
        <button class="flex-shrink-0 px-4 py-2 rounded-xl bg-marena-ivory text-marena-ink-50 border border-marena-ink-10 text-sm">Tasks</button>
    </div>

    @if(isset($reminders) && $reminders->count() > 0)
        <div class="space-y-2">
            @foreach($reminders as $reminder)
                <div class="card flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-marena-sage-mist flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-marena-ink">{{ $reminder->title ?? 'Reminder' }}</p>
                        <p class="text-xs text-marena-ink-50">{{ $reminder->scheduled_at?->format('M j, H:i') ?? '' }} &middot; {{ $reminder->type ?? '' }}</p>
                    </div>
                    <button class="p-2 rounded-full hover:bg-marena-sage-mist" aria-label="Snooze">
                        <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" title="No reminders set" />
        </div>
    @endif
</div>
@endsection