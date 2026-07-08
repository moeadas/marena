@extends('layouts.app', ['pageTitle' => 'Alerts Center'])

@section('bottom_nav')
    @include('partials.bottom-nav-caregiver', ['current' => 'alerts'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ filter: 'all' }">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Alerts Center</h1>

    <!-- Filter -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
        @php
            $filters = ['all' => 'All', 'critical' => 'Critical', 'high' => 'High', 'medium' => 'Medium', 'low' => 'Low'];
        @endphp
        @foreach($filters as $key => $label)
            <button @click="filter = '{{ $key }}'" :class="filter === '{{ $key }}' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all">{{ $label }}</button>
        @endforeach
    </div>

    @if(isset($alerts) && $alerts->count() > 0)
        <div class="space-y-3">
            @foreach($alerts as $alert)
                <x-alert-card :severity="$alert->severity ?? 'medium'" :title="$alert->title ?? 'Alert'" :time="$alert->created_at?->diffForHumans() ?? ''">
                    {{ $alert->message ?? '' }}
                </x-alert-card>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z;M12 9v4M12 17h.01" title="No active alerts" />
        </div>
    @endif
</div>
@endsection