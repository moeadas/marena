@extends('layouts.app', ['pageTitle' => 'Beneficiaries'])

@section('bottom_nav')
    @include('partials.bottom-nav-provider', ['current' => 'beneficiaries'])
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-marena-teal-deep">My Beneficiaries</h1>
        <button class="btn-sm btn-outline">Search</button>
    </div>

    @if(isset($beneficiaries) && $beneficiaries->count() > 0)
        <div class="space-y-3">
            @foreach($beneficiaries as $beneficiary)
                <div class="card">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-marena-sage-mist flex items-center justify-center text-sm font-semibold text-marena-teal-deep flex-shrink-0">
                            {{ strtoupper($beneficiary->name[0] ?? '?') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm text-marena-ink truncate">{{ $beneficiary->name ?? 'Beneficiary' }}</p>
                            <p class="text-xs text-marena-ink-50">{{ $beneficiary->age ?? '' }} yrs &middot; {{ $beneficiary->location ?? '' }}</p>
                        </div>
                        <x-status-badge :status="$beneficiary->status ?? 'active'" />
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-marena-ink-10">
                        <div>
                            <p class="text-xs text-marena-ink-50">Next Intervention</p>
                            <p class="text-sm font-medium text-marena-teal">{{ $beneficiary->next_visit ?? 'Not scheduled' }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="btn-sm btn-secondary">View</button>
                            <button class="btn-sm btn-outline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2;circle cx=12 cy=7 r=4" title="No beneficiaries linked" />
        </div>
    @endif
</div>
@endsection