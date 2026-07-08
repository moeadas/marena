@extends('layouts.app', ['pageTitle' => 'Health Graphs'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'home'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Health Trends</h1>
    <p class="text-sm text-marena-ink-50 -mt-3">Track your health metrics over time.</p>

    <!-- Metric Cards with Charts -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        @php
            $metrics = [
                ['label' => 'Blood Pressure', 'value' => '120/80', 'unit' => 'mmHg', 'trend' => 'stable', 'bars' => [60, 65, 70, 68, 72, 75, 70]],
                ['label' => 'Glucose', 'value' => '5.4', 'unit' => 'mmol/L', 'trend' => 'down', 'bars' => [80, 75, 70, 72, 65, 60, 58]],
                ['label' => 'Weight', 'value' => '72.5', 'unit' => 'kg', 'trend' => 'down', 'bars' => [90, 88, 85, 84, 82, 80, 78]],
                ['label' => 'Mood', 'value' => '7/10', 'unit' => '', 'trend' => 'up', 'bars' => [40, 45, 50, 55, 60, 65, 70]],
                ['label' => 'Mobility', 'value' => 'Good', 'unit' => '', 'trend' => 'up', 'bars' => [50, 55, 58, 62, 65, 68, 72]],
                ['label' => 'Heart Rate', 'value' => '72', 'unit' => 'bpm', 'trend' => 'stable', 'bars' => [70, 72, 68, 71, 73, 70, 72]],
            ];
        @endphp
        @foreach($metrics as $metric)
            <x-health-metric-card :label="$metric['label']" :value="$metric['value']" :unit="$metric['unit']" :trend="$metric['trend']">
                <!-- Simple CSS bar chart -->
                <div class="flex items-end gap-1 h-12 mt-2">
                    @foreach($metric['bars'] as $bar)
                        <div class="flex-1 bg-marena-sage rounded-t" style="height: {{ $bar }}%"></div>
                    @endforeach
                </div>
            </x-health-metric-card>
        @endforeach
    </div>
</div>
@endsection