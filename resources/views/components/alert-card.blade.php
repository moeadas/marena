@props([
    'severity' => 'medium',
    'title' => '',
    'time' => '',
])

@php
    $styles = [
        'critical' => 'alert-critical',
        'high' => 'alert-high',
        'medium' => 'alert-medium',
        'low' => 'alert-low',
    ];
    $icons = [
        'critical' => 'M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z;M12 9v4;M12 17h.01',
        'high' => 'M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z;M12 9v4;M12 17h.01',
        'medium' => 'M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83',
        'low' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z',
    ];
    $class = $styles[$severity] ?? 'alert-medium';
    $iconPaths = explode(';', $icons[$severity] ?? $icons['medium']);
@endphp

<div class="card {{ $class }} flex items-start gap-3 mfade">
    <div class="flex-shrink-0 mt-0.5">
        <svg class="w-5 h-5 text-marena-ink-50" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            @foreach($iconPaths as $path)
                <path d="{{ trim($path) }}"/>
            @endforeach
        </svg>
    </div>
    <div class="flex-1 min-w-0">
        <p class="font-medium text-sm text-marena-ink">{{ $title }}</p>
        @isset($slot)
            <div class="mt-1 text-sm text-marena-ink-50">{{ $slot }}</div>
        @endisset
    </div>
    @if($time)
        <span class="text-xs text-marena-ink-50 flex-shrink-0">{{ $time }}</span>
    @endif
</div>