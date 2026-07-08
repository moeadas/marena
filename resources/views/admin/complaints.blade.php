@extends('layouts.app', ['pageTitle' => 'Complaints'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'complaints'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ filter: 'all' }">
    <h1 class="text-2xl font-semibold text-marena-teal-deep">Complaints</h1>

    <!-- Filters -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
        @foreach(['all' => 'All', 'critical' => 'Critical', 'open' => 'Open', 'resolved' => 'Resolved'] as $key => $label)
            <button @click="filter = '{{ $key }}'" :class="filter === '{{ $key }}' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all">{{ $label }}</button>
        @endforeach
    </div>

    @if(isset($complaints) && $complaints->count() > 0)
        <div class="space-y-3">
            @foreach($complaints as $complaint)
                <div class="card {{ $complaint->severity === 'critical' ? 'alert-critical' : ($complaint->severity === 'high' ? 'alert-high' : '') }}">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm text-marena-ink">{{ $complaint->title ?? 'Complaint' }}</p>
                            <p class="text-xs text-marena-ink-50 mt-1">From: {{ $complaint->from ?? 'Unknown' }} &middot; {{ $complaint->created_at?->diffForHumans() ?? '' }}</p>
                            <p class="text-xs text-marena-ink-50 mt-0.5">Assigned: {{ $complaint->assigned_admin ?? 'Unassigned' }}</p>
                        </div>
                        <div class="flex flex-col items-end gap-1.5">
                            @if($complaint->severity === 'critical')
                                <span class="badge-critical">Critical</span>
                            @elseif($complaint->severity === 'high')
                                <span class="badge-pending">High</span>
                            @else
                                <span class="badge-scheduled">Normal</span>
                            @endif
                            <x-status-badge :status="$complaint->status ?? 'open'" />
                        </div>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <button class="btn-sm btn-primary flex-1">View Details</button>
                        <button class="btn-sm btn-outline flex-1">Assign</button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z;M12 9v4M12 17h.01" title="No complaints" />
        </div>
    @endif
</div>
@endsection