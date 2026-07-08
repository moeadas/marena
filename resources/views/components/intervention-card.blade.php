@props([
    'time' => '',
    'person' => '',
    'serviceType' => '',
    'status' => 'scheduled',
    'location' => '',
])

<div class="card flex items-center gap-3">
    <!-- Time -->
    <div class="flex-shrink-0 text-center w-14">
        <p class="text-sm font-semibold text-marena-teal-deep">{{ $time }}</p>
    </div>

    <!-- Divider -->
    <div class="w-px h-12 bg-marena-ink-10"></div>

    <!-- Content -->
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2">
            <p class="font-medium text-sm text-marena-ink truncate">{{ $person }}</p>
            <x-status-badge :status="$status" />
        </div>
        <p class="text-xs text-marena-ink-50 truncate">{{ $serviceType }}</p>
        @if($location)
            <p class="text-xs text-marena-ink-50 truncate mt-0.5">
                <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ $location }}
            </p>
        @endif
    </div>

    <!-- Action -->
    <button class="flex-shrink-0 p-2 rounded-full hover:bg-marena-sage-mist transition-colors" aria-label="View details">
        <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
    </button>
</div>