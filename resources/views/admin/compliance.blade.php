@extends('layouts.app', ['pageTitle' => 'Compliance'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'compliance'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ tab: 'consent' }">
    <h1 class="text-2xl font-semibold text-marena-teal-deep">Compliance & Audit</h1>

    <!-- Tabs -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
        @php
            $tabs = [
                ['key' => 'consent', 'label' => 'Consent Logs'],
                ['key' => 'audit', 'label' => 'Audit Trail'],
                ['key' => 'retention', 'label' => 'Data Retention'],
                ['key' => 'flagged', 'label' => 'Flagged Accounts'],
            ];
        @endphp
        @foreach($tabs as $tab)
            <button @click="tab = '{{ $tab['key'] }}'" :class="tab === '{{ $tab['key'] }}' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all">{{ $tab['label'] }}</button>
        @endforeach
    </div>

    <!-- Consent Logs -->
    <div x-show="tab === 'consent'" x-transition class="space-y-3">
        @if(isset($consentLogs) && $consentLogs->count() > 0)
            @foreach($consentLogs as $log)
                <div class="card-tight flex items-center gap-3">
                    <svg class="w-5 h-5 text-marena-success flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-marena-ink">{{ $log->user?->name ?? 'User' }}</p>
                        <p class="text-xs text-marena-ink-50">{{ $log->consent_type ?? '' }} &middot; {{ $log->created_at?->diffForHumans() ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card">
                <x-empty-state icon="M9 11l3 3L22 4;M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" title="No consent logs" />
            </div>
        @endif
    </div>

    <!-- Audit Trail -->
    <div x-show="tab === 'audit'" x-transition class="space-y-2">
        @if(isset($auditTrail) && $auditTrail->count() > 0)
            @foreach($auditTrail as $audit)
                <div class="card-tight flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-marena-teal flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-marena-ink-70">{{ $audit->action ?? 'Action' }}</p>
                        <p class="text-xs text-marena-ink-50">{{ $audit->user?->name ?? '' }} &middot; {{ $audit->created_at?->format('M j, Y H:i') ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card">
                <x-empty-state icon="M3 3v18h18;M18 17V9M13 17V5M8 17v-3" title="No audit entries" />
            </div>
        @endif
    </div>

    <!-- Data Retention -->
    <div x-show="tab === 'retention'" x-transition class="space-y-3">
        <div class="card flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-marena-ink">Data retention period</p>
                <p class="text-xs text-marena-ink-50">How long to keep inactive user data</p>
            </div>
            <select class="input w-32"><option>2 years</option><option>5 years</option><option>10 years</option></select>
        </div>
        <div class="card flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-marena-ink">Auto-delete inactive accounts</p>
                <p class="text-xs text-marena-ink-50">After retention period expires</p>
            </div>
            <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
        </div>
        <div class="card">
            <p class="text-sm text-marena-ink-50 mb-3">Data retention status:</p>
            <div class="grid grid-cols-3 gap-3">
                <div class="text-center"><p class="text-2xl font-semibold text-marena-teal-deep">{{ $retention['active'] ?? 0 }}</p><p class="text-xs text-marena-ink-50">Active</p></div>
                <div class="text-center"><p class="text-2xl font-semibold text-marena-warn">{{ $retention['expiring'] ?? 0 }}</p><p class="text-xs text-marena-ink-50">Expiring</p></div>
                <div class="text-center"><p class="text-2xl font-semibold text-marena-danger">{{ $retention['overdue'] ?? 0 }}</p><p class="text-xs text-marena-ink-50">Overdue</p></div>
            </div>
        </div>
    </div>

    <!-- Flagged Accounts -->
    <div x-show="tab === 'flagged'" x-transition class="space-y-3">
        @if(isset($flaggedAccounts) && $flaggedAccounts->count() > 0)
            @foreach($flaggedAccounts as $account)
                <div class="card alert-critical flex items-center gap-3">
                    <svg class="w-5 h-5 text-marena-danger flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4M12 17h.01"/></svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-marena-ink">{{ $account->name ?? 'Account' }}</p>
                        <p class="text-xs text-marena-ink-50">{{ $account->reason ?? '' }}</p>
                    </div>
                    <button class="btn-sm btn-primary">Review</button>
                </div>
            @endforeach
        @else
            <div class="card">
                <x-empty-state icon="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z;M12 9v4M12 17h.01" title="No flagged accounts" />
            </div>
        @endif
    </div>
</div>
@endsection