@extends('layouts.app', ['pageTitle' => 'Company Management'])

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-marena-teal-deep">Company Management</h1>
        <button class="btn-sm btn-primary">+ Add Employee</button>
    </div>

    <!-- Employees -->
    <div>
        <x-section-header title="Employees" />
        @if(isset($employees) && $employees->count() > 0)
            <div class="space-y-3">
                @foreach($employees as $emp)
                    <a href="{{ route('provider.employee-profile', $emp->id ?? 1) }}" class="card flex items-center gap-3 hover:bg-marena-sage-mist transition-colors">
                        <div class="w-10 h-10 rounded-full bg-marena-sage-mist flex items-center justify-center text-sm font-semibold text-marena-teal-deep flex-shrink-0">
                            {{ strtoupper($emp->name[0] ?? '?') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-marena-ink truncate">{{ $emp->name ?? 'Employee' }}</p>
                            <p class="text-xs text-marena-ink-50">{{ $emp->role ?? '' }} &middot; {{ $emp->assigned_count ?? 0 }} beneficiaries</p>
                        </div>
                        <x-status-badge :status="$emp->status ?? 'active'" />
                    </a>
                @endforeach
            </div>
        @else
            <div class="card">
                <x-empty-state icon="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2;circle cx=9 cy=7 r=4" title="No employees yet" cta="Add employee" cta-route="#" />
            </div>
        @endif
    </div>

    <!-- Assigned Beneficiaries -->
    <div>
        <x-section-header title="Assigned Beneficiaries" />
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @if(isset($beneficiaries) && $beneficiaries->count() > 0)
                @foreach($beneficiaries as $b)
                    <div class="card flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-marena-sage-mist flex items-center justify-center text-sm font-semibold text-marena-teal-deep">
                            {{ strtoupper($b->name[0] ?? '?') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-marena-ink truncate">{{ $b->name ?? 'Beneficiary' }}</p>
                            <p class="text-xs text-marena-ink-50">Assigned to: {{ $b->employee ?? '—' }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-2 card">
                    <x-empty-state icon="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2;circle cx=12 cy=7 r=4" title="No beneficiaries assigned" />
                </div>
            @endif
        </div>
    </div>

    <!-- Quality Overview -->
    <div>
        <x-section-header title="Quality Overview" />
        <div class="grid grid-cols-3 gap-3">
            <div class="card text-center">
                <p class="text-2xl font-semibold text-marena-teal-deep">{{ $stats['completion'] ?? '95%' }}</p>
                <p class="text-xs text-marena-ink-50">Completion</p>
            </div>
            <div class="card text-center">
                <p class="text-2xl font-semibold text-marena-teal-deep">{{ $stats['on_time'] ?? '88%' }}</p>
                <p class="text-xs text-marena-ink-50">On Time</p>
            </div>
            <div class="card text-center">
                <p class="text-2xl font-semibold text-marena-teal-deep">{{ $stats['satisfaction'] ?? '4.7' }}</p>
                <p class="text-xs text-marena-ink-50">Satisfaction</p>
            </div>
        </div>
    </div>
</div>
@endsection