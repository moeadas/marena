@props([
    'label' => '',
    'value' => '',
    'unit' => '',
    'trend' => 'stable', // up, down, stable
])

@php
    $trendIcons = [
        'up' => 'M7 17l5-5 5 5M7 7l5 5 5-5',
        'down' => 'M7 7l5 5 5-5',
        'stable' => 'M5 12h14',
    ];
    $trendColors = [
        'up' => 'text-marena-success',
        'down' => 'text-marena-danger',
        'stable' => 'text-marena-ink-50',
    ];
@endphp

<div class="card">
    <div class="flex items-center justify-between mb-2">
        <p class="text-xs font-medium text-marena-ink-50 uppercase tracking-wide">{{ $label }}</p>
        <svg class="w-4 h-4 {{ $trendColors[$trend] ?? $trendColors['stable'] }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $trendIcons[$trend] ?? $trendIcons['stable'] }}"/></svg>
    </div>
    <div class="flex items-baseline gap-1">
        <span class="text-2xl font-semibold text-marena-teal-deep">{{ $value }}</span>
        @if($unit)
            <span class="text-sm text-marena-ink-50">{{ $unit }}</span>
        @endif
    </div>
    <!-- Mini graph placeholder -->
    @isset($slot)
        <div class="mt-2">{{ $slot }}</div>
    @endisset
</div>