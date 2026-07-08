@extends('layouts.app', ['pageTitle' => 'Analytics'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'analytics'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-semibold text-marena-teal-deep">Analytics</h1>

    <!-- KPI Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="card text-center">
            <p class="text-xs text-marena-ink-50 uppercase tracking-wide">Total Services</p>
            <p class="text-3xl font-semibold text-marena-teal-deep mt-1">{{ $stats['total_services'] ?? 0 }}</p>
        </div>
        <div class="card text-center">
            <p class="text-xs text-marena-ink-50 uppercase tracking-wide">Completion Rate</p>
            <p class="text-3xl font-semibold text-marena-success mt-1">{{ $stats['completion_rate'] ?? '0%' }}</p>
        </div>
        <div class="card text-center">
            <p class="text-xs text-marena-ink-50 uppercase tracking-wide">Avg Rating</p>
            <p class="text-3xl font-semibold text-marena-teal-deep mt-1">{{ $stats['avg_rating'] ?? '0.0' }}</p>
        </div>
        <div class="card text-center">
            <p class="text-xs text-marena-ink-50 uppercase tracking-wide">Missed Rate</p>
            <p class="text-3xl font-semibold text-marena-danger mt-1">{{ $stats['missed_rate'] ?? '0%' }}</p>
        </div>
    </div>

    <!-- Service Demand Chart -->
    <div>
        <x-section-header title="Service Demand by Category" />
        <div class="card">
            <div class="space-y-3">
                @php
                    $demand = [
                        ['label' => 'Nursing', 'value' => 85],
                        ['label' => 'Physiotherapy', 'value' => 70],
                        ['label' => 'Home Care', 'value' => 90],
                        ['label' => 'Medication', 'value' => 55],
                        ['label' => 'Transport', 'value' => 40],
                    ];
                @endphp
                @foreach($demand as $item)
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-marena-ink-70 w-24">{{ $item['label'] }}</span>
                        <div class="flex-1 h-6 rounded-lg bg-marena-ink-10 overflow-hidden">
                            <div class="h-full bg-marena-teal rounded-lg" style="width: {{ $item['value'] }}%"></div>
                        </div>
                        <span class="text-xs text-marena-ink-50 w-8">{{ $item['value'] }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Completion Trends (CSS Bar Chart) -->
    <div>
        <x-section-header title="Completion Rate (Last 7 Months)" />
        <div class="card">
            <div class="flex items-end gap-2 h-40">
                @php
                    $months = [88, 91, 85, 93, 90, 94, 92];
                    $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];
                @endphp
                @foreach($months as $i => $val)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-marena-sage rounded-t" style="height: {{ $val }}%"></div>
                        <span class="text-[10px] text-marena-ink-50">{{ $labels[$i] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Missed Trends -->
    <div>
        <x-section-header title="Missed Interventions Trend" />
        <div class="card">
            <div class="flex items-end gap-2 h-40">
                @php
                    $missed = [5, 3, 8, 2, 4, 3, 6];
                @endphp
                @foreach($missed as $i => $val)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-marena-danger/60 rounded-t" style="height: {{ $val * 10 }}%"></div>
                        <span class="text-[10px] text-marena-ink-50">{{ $labels[$i] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection