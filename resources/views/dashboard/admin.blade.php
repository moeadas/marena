@extends('layouts.app', ['pageTitle' => 'Admin Dashboard'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'dashboard'])
@endsection

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-marena-teal-deep">Admin Dashboard</h1>
        <p class="text-sm text-marena-ink-50 mt-1">Platform overview and management.</p>
    </div>

    <!-- KPIs Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="card">
            <p class="text-xs text-marena-ink-50 uppercase tracking-wide">Total Users</p>
            <p class="text-3xl font-semibold text-marena-teal-deep mt-1">{{ $kpis['total_users'] ?? 0 }}</p>
            <p class="text-xs text-marena-success mt-1">+{{ $kpis['new_users'] ?? 0 }} this week</p>
        </div>
        <div class="card">
            <p class="text-xs text-marena-ink-50 uppercase tracking-wide">Active Interventions</p>
            <p class="text-3xl font-semibold text-marena-teal-deep mt-1">{{ $kpis['active_interventions'] ?? 0 }}</p>
            <p class="text-xs text-marena-ink-50 mt-1">{{ $kpis['today_interventions'] ?? 0 }} today</p>
        </div>
        <div class="card">
            <p class="text-xs text-marena-ink-50 uppercase tracking-wide">Pending Approvals</p>
            <p class="text-3xl font-semibold text-marena-warn mt-1">{{ $kpis['pending_approvals'] ?? 0 }}</p>
            <p class="text-xs text-marena-ink-50 mt-1">Awaiting review</p>
        </div>
        <div class="card">
            <p class="text-xs text-marena-ink-50 uppercase tracking-wide">Open Complaints</p>
            <p class="text-3xl font-semibold text-marena-danger mt-1">{{ $kpis['open_complaints'] ?? 0 }}</p>
            <p class="text-xs text-marena-ink-50 mt-1">{{ $kpis['critical_complaints'] ?? 0 }} critical</p>
        </div>
    </div>

    <!-- Pending Approvals -->
    <div>
        <x-section-header title="Pending Approvals" action-label="View all" action-route="{{ route('admin.pending-approvals') }}" />
        @if(isset($pendingApprovals) && $pendingApprovals->count() > 0)
            <div class="space-y-2">
                @foreach($pendingApprovals->take(5) as $approval)
                    <div class="card-tight flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-marena-warn/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-marena-warn" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-marena-ink truncate">{{ $approval->name ?? 'Item' }}</p>
                            <p class="text-xs text-marena-ink-50">{{ $approval->type ?? '' }} &middot; {{ $approval->created_at?->diffForHumans() ?? '' }}</p>
                        </div>
                        <a href="{{ route('admin.pending-approvals') }}" class="btn-sm btn-primary">Review</a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M9 11l3 3L22 4;M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" title="No pending approvals" />
            </div>
        @endif
    </div>

    <!-- Recent Complaints -->
    <div>
        <x-section-header title="Recent Complaints" action-label="View all" action-route="{{ route('admin.complaints') }}" />
        @if(isset($complaints) && $complaints->count() > 0)
            <div class="space-y-2">
                @foreach($complaints->take(3) as $complaint)
                    <div class="card-tight flex items-center gap-3 {{ $complaint->severity === 'critical' ? 'alert-critical' : '' }}">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-marena-ink truncate">{{ $complaint->title ?? 'Complaint' }}</p>
                            <p class="text-xs text-marena-ink-50">{{ $complaint->created_at?->diffForHumans() ?? '' }}</p>
                        </div>
                        <x-status-badge :status="$complaint->status ?? 'pending'" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z;M12 9v4M12 17h.01" title="No recent complaints" />
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div>
        <x-section-header title="Quick Actions" />
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('admin.pending-approvals') }}" class="card flex flex-col items-center gap-2 hover:bg-marena-sage-mist transition-colors">
                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                <span class="text-sm font-medium text-marena-ink-70">Approvals</span>
            </a>
            <a href="{{ route('admin.service-catalogue') }}" class="card flex flex-col items-center gap-2 hover:bg-marena-sage-mist transition-colors">
                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <span class="text-sm font-medium text-marena-ink-70">Services</span>
            </a>
            <a href="{{ route('admin.matching') }}" class="card flex flex-col items-center gap-2 hover:bg-marena-sage-mist transition-colors">
                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <span class="text-sm font-medium text-marena-ink-70">Matching</span>
            </a>
            <a href="{{ route('admin.analytics') }}" class="card flex flex-col items-center gap-2 hover:bg-marena-sage-mist transition-colors">
                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-3"/></svg>
                <span class="text-sm font-medium text-marena-ink-70">Analytics</span>
            </a>
        </div>
    </div>
</div>
@endsection