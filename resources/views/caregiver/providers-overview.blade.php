@extends('layouts.app', ['pageTitle' => 'Providers Overview'])

@section('bottom_nav')
    @include('partials.bottom-nav-caregiver', ['current' => 'providers'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Providers</h1>
    <p class="text-sm text-marena-ink-50 -mt-3">All healthcare providers linked to the care circle.</p>

    @if(isset($providers) && $providers->count() > 0)
        <div class="space-y-3">
            @foreach($providers as $provider)
                <div class="card">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-marena-sage-mist flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm text-marena-ink truncate">{{ $provider->name ?? 'Provider' }}</p>
                            <p class="text-xs text-marena-ink-50">{{ $provider->specialty ?? '' }}</p>
                            <p class="text-xs text-marena-teal mt-0.5">Next: {{ $provider->next_visit ?? 'Not scheduled' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <button class="btn-sm btn-secondary flex-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Call
                        </button>
                        <button class="btn-sm btn-outline flex-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Message
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" title="No providers linked yet" />
        </div>
    @endif
</div>
@endsection