@props([
    'name' => '',
    'role' => '',
    'status' => 'active',
    'permissions' => [],
])

@php
    $statusColors = [
        'active' => 'bg-marena-success',
        'pending' => 'bg-marena-warn',
        'inactive' => 'bg-marena-ink-30',
    ];
    $statusLabels = [
        'active' => 'Active',
        'pending' => 'Pending',
        'inactive' => 'Inactive',
    ];
@endphp

<div class="card flex items-center gap-3">
    <div class="relative flex-shrink-0">
        <div class="w-12 h-12 rounded-full bg-marena-sage-mist flex items-center justify-center text-lg font-semibold text-marena-teal-deep">
            {{ strtoupper($name[0] ?? '?') }}
        </div>
        <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full {{ $statusColors[$status] ?? $statusColors['active'] }} ring-2 ring-marena-ivory"></span>
    </div>

    <div class="flex-1 min-w-0">
        <p class="font-medium text-sm text-marena-ink truncate">{{ $name }}</p>
        <p class="text-xs text-marena-ink-50">{{ $role }} &middot; {{ $statusLabels[$status] ?? ucfirst($status) }}</p>
        @if(!empty($permissions))
            <div class="flex flex-wrap gap-1 mt-1">
                @foreach($permissions as $perm)
                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-marena-sage-mist text-marena-teal">{{ $perm }}</span>
                @endforeach
            </div>
        @endif
    </div>

    @isset($slot)
        <div class="flex-shrink-0">{{ $slot }}</div>
    @endisset
</div>