@extends('layouts.app', ['pageTitle' => 'Pending Approvals'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'approvals'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ tab: 'providers' }">
    <h1 class="text-2xl font-semibold text-marena-teal-deep">Pending Approvals</h1>

    <!-- Tabs -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
        @php
            $tabs = [
                ['key' => 'providers', 'label' => 'Providers', 'count' => $counts['providers'] ?? 0],
                ['key' => 'companies', 'label' => 'Companies', 'count' => $counts['companies'] ?? 0],
                ['key' => 'beneficiaries', 'label' => 'Beneficiaries', 'count' => $counts['beneficiaries'] ?? 0],
                ['key' => 'caregivers', 'label' => 'Caregivers', 'count' => $counts['caregivers'] ?? 0],
            ];
        @endphp
        @foreach($tabs as $tab)
            <button @click="tab = '{{ $tab['key'] }}'" :class="tab === '{{ $tab['key'] }}' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all flex items-center gap-2">
                {{ $tab['label'] }}
                @if($tab['count'] > 0)
                    <span class="px-1.5 py-0.5 rounded-full bg-marena-warn text-white text-xs">{{ $tab['count'] }}</span>
                @endif
            </button>
        @endforeach
    </div>

    <!-- Approvals List -->
    @if(isset($approvals) && $approvals->count() > 0)
        <div class="space-y-3">
            @foreach($approvals as $approval)
                <div class="card">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-marena-sage-mist flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm text-marena-ink">{{ $approval->name ?? 'Item' }}</p>
                            <p class="text-xs text-marena-ink-50 mt-0.5">{{ $approval->type ?? '' }} &middot; Submitted {{ $approval->created_at?->diffForHumans() ?? '' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <button class="btn-sm btn-primary flex-1">Approve</button>
                        <button class="btn-sm btn-outline flex-1 text-marena-danger border-marena-danger/30">Reject</button>
                        <button class="btn-sm btn-secondary flex-1">Request Info</button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M9 11l3 3L22 4;M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" title="No pending approvals" />
        </div>
    @endif
</div>
@endsection