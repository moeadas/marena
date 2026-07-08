@extends('layouts.app', ['pageTitle' => 'Employee Profile'])

@section('content')
<div class="space-y-6">
    <!-- Employee Header -->
    <div class="card flex items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-marena-sage-mist flex items-center justify-center text-xl font-semibold text-marena-teal-deep">
            {{ strtoupper($employee->name[0] ?? 'E') }}
        </div>
        <div class="flex-1">
            <h1 class="text-lg font-semibold text-marena-teal-deep">{{ $employee->name ?? 'Employee' }}</h1>
            <p class="text-sm text-marena-ink-50">{{ $employee->role ?? '' }}</p>
            <div class="mt-1"><x-status-badge :status="$employee->status ?? 'active'" /></div>
        </div>
    </div>

    <!-- Verification -->
    <div>
        <x-section-header title="Verification" />
        <div class="card space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-sm text-marena-ink-70">Identity Verified</span>
                <span class="badge-completed">✓ Verified</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-marena-ink-70">Credentials Checked</span>
                <span class="badge-completed">✓ Verified</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-marena-ink-70">Background Check</span>
                <span class="badge-pending">Pending</span>
            </div>
        </div>
    </div>

    <!-- Assigned Beneficiaries -->
    <div>
        <x-section-header title="Assigned Beneficiaries" />
        @if(isset($beneficiaries) && $beneficiaries->count() > 0)
            <div class="space-y-2">
                @foreach($beneficiaries as $b)
                    <div class="card-tight flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-marena-sage-mist flex items-center justify-center text-xs font-semibold text-marena-teal-deep">
                            {{ strtoupper($b->name[0] ?? '?') }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-marena-ink">{{ $b->name ?? 'Beneficiary' }}</p>
                            <p class="text-xs text-marena-ink-50">Next: {{ $b->next_visit ?? '—' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card"><x-empty-state icon="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2;circle cx=12 cy=7 r=4" title="No beneficiaries assigned" /></div>
        @endif
    </div>

    <!-- Availability -->
    <div>
        <x-section-header title="Availability" />
        <div class="card">
            <div class="grid grid-cols-7 gap-1">
                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                    <div class="text-center">
                        <p class="text-xs text-marena-ink-50 mb-1">{{ $day[0] }}</p>
                        <div class="aspect-square rounded-lg @if(in_array($day, ['Mon','Tue','Wed','Thu','Fri'])) bg-marena-sage-mist @else bg-marena-ink-10 @endif"></div>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-marena-ink-50 mt-2 text-center">Available Mon–Fri</p>
        </div>
    </div>
</div>
@endsection