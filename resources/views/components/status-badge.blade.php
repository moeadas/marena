@props([
    'status' => 'scheduled',
])

@php
    $styles = [
        'scheduled' => 'badge-scheduled',
        'completed' => 'badge-completed',
        'missed' => 'badge-missed',
        'cancelled' => 'badge-cancelled',
        'pending' => 'badge-pending',
        'critical' => 'badge-critical',
    ];
    $labels = [
        'scheduled' => 'Scheduled',
        'completed' => 'Completed',
        'missed' => 'Missed',
        'cancelled' => 'Cancelled',
        'pending' => 'Pending',
        'critical' => 'Critical',
    ];
    $class = $styles[$status] ?? 'badge-scheduled';
    $label = $labels[$status] ?? ucfirst($status);
@endphp

<span class="{{ $class }}">
    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
    {{ $label }}
</span>