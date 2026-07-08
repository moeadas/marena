@extends('layouts.app', ['pageTitle' => 'Service History'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'schedule'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ showFilters: false }">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-marena-teal-deep">Service History</h1>
        <button @click="showFilters = !showFilters" class="btn-sm btn-outline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            Filter
        </button>
    </div>

    <!-- Filters -->
    <div x-show="showFilters" x-transition class="card space-y-4">
        <div>
            <label class="label">Date Range</label>
            <div class="flex gap-2">
                <input type="date" name="from" class="input flex-1">
                <input type="date" name="to" class="input flex-1">
            </div>
        </div>
        <div>
            <label class="label">Provider</label>
            <select class="input">
                <option value="">All providers</option>
            </select>
        </div>
        <div>
            <label class="label">Service Type</label>
            <select class="input">
                <option value="">All types</option>
            </select>
        </div>
        <div>
            <label class="label">Status</label>
            <div class="flex flex-wrap gap-2">
                <button class="btn-sm btn-secondary">All</button>
                <button class="btn-sm btn-outline">Completed</button>
                <button class="btn-sm btn-outline">Scheduled</button>
                <button class="btn-sm btn-outline">Missed</button>
                <button class="btn-sm btn-outline">Cancelled</button>
            </div>
        </div>
        <button class="btn-primary w-full">Apply Filters</button>
    </div>

    <!-- List -->
    @if(isset($interventions) && $interventions->count() > 0)
        <div class="space-y-3">
            @foreach($interventions as $intervention)
                <x-intervention-card
                    :time="$intervention->scheduled_at?->format('M j, H:i') ?? ''"
                    :person="$intervention->provider?->name ?? 'Provider'"
                    :service-type="$intervention->service?->name ?? 'Service'"
                    :status="$intervention->status ?? 'scheduled'"
                />
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state
                icon="M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z"
                title="No service history yet"
                cta="Request a service"
                cta-route="{{ route('beneficiary.request-service') }}"
            />
        </div>
    @endif
</div>
@endsection