@extends('layouts.app', ['pageTitle' => 'Company Dashboard'])

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-xl font-semibold text-marena-teal-deep">Company Overview</h1>
        <p class="text-sm text-marena-ink-50 mt-1">Manage your team and assignments.</p>
    </div>

    <!-- Employees -->
    <div>
        <x-section-header title="Employees" action-label="Manage" action-route="{{ route('provider.company-management') }}" />
        @if(isset($employees) && $employees->count() > 0)
            <div class="space-y-2">
                @foreach($employees as $emp)
                    <div class="card-tight flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-marena-sage-mist flex items-center justify-center text-sm font-semibold text-marena-teal-deep flex-shrink-0">
                            {{ strtoupper($emp->name[0] ?? '?') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-marena-ink truncate">{{ $emp->name ?? 'Employee' }}</p>
                            <p class="text-xs text-marena-ink-50">{{ $emp->role ?? '' }}</p>
                        </div>
                        <x-status-badge :status="$emp->status ?? 'active'" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2;circle cx=9 cy=7 r=4" title="No employees yet" cta="Add employee" cta-route="{{ route('provider.company-management') }}" />
            </div>
        @endif
    </div>

    <!-- Assigned Beneficiaries -->
    <div>
        <x-section-header title="Assigned Beneficiaries" />
        @if(isset($beneficiaries) && $beneficiaries->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($beneficiaries as $beneficiary)
                    <div class="card flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-marena-sage-mist flex items-center justify-center text-sm font-semibold text-marena-teal-deep flex-shrink-0">
                            {{ strtoupper($beneficiary->name[0] ?? '?') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-marena-ink truncate">{{ $beneficiary->name ?? 'Beneficiary' }}</p>
                            <p class="text-xs text-marena-ink-50">Next: {{ $beneficiary->next_visit ?? 'Not scheduled' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2;circle cx=12 cy=7 r=4" title="No beneficiaries assigned" />
            </div>
        @endif
    </div>

    <!-- Quality Overview -->
    <div>
        <x-section-header title="Quality Overview" />
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="card text-center">
                <p class="text-3xl font-semibold text-marena-teal-deep">{{ $stats['completion_rate'] ?? '0%' }}</p>
                <p class="text-xs text-marena-ink-50 mt-1">Completion</p>
            </div>
            <div class="card text-center">
                <p class="text-3xl font-semibold text-marena-teal-deep">{{ $stats['avg_rating'] ?? '0.0' }}</p>
                <p class="text-xs text-marena-ink-50 mt-1">Avg Rating</p>
            </div>
            <div class="card text-center">
                <p class="text-3xl font-semibold text-marena-teal-deep">{{ $stats['active_visits'] ?? 0 }}</p>
                <p class="text-xs text-marena-ink-50 mt-1">Active Visits</p>
            </div>
            <div class="card text-center">
                <p class="text-3xl font-semibold text-marena-teal-deep">{{ $stats['missed_rate'] ?? '0%' }}</p>
                <p class="text-xs text-marena-ink-50 mt-1">Missed Rate</p>
            </div>
        </div>
    </div>
</div>
@endsection