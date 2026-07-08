@props([
    'name' => '',
    'lastMessage' => '',
    'time' => '',
    'unread' => 0,
    'avatar' => '',
])

<div class="card-tight flex items-center gap-3 hover:bg-marena-sage-mist/50 transition-colors cursor-pointer">
    <div class="relative flex-shrink-0">
        <div class="w-10 h-10 rounded-full bg-marena-sage-mist flex items-center justify-center text-sm font-semibold text-marena-teal-deep">
            {{ strtoupper($name[0] ?? '?') }}
        </div>
        @if($unread > 0)
            <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-marena-danger text-white text-[10px] font-bold flex items-center justify-center">
                {{ $unread > 9 ? '9+' : $unread }}
            </span>
        @endif
    </div>

    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between">
            <p class="font-medium text-sm text-marena-ink truncate">{{ $name }}</p>
            @if($time)
                <span class="text-xs text-marena-ink-50 flex-shrink-0 ml-2">{{ $time }}</span>
            @endif
        </div>
        @if($lastMessage)
            <p class="text-xs text-marena-ink-50 truncate">{{ $lastMessage }}</p>
        @endif
    </div>
</div>