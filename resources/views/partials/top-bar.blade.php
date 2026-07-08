@php
    $pageTitle = $pageTitle ?? 'MARÉNA Care';
    $hasSidebar = auth()->check() && auth()->user()->hasRole('admin');
@endphp

<header class="sticky top-0 z-30 bg-marena-ivory/95 backdrop-blur-sm border-b border-marena-ink-10 safe-top {{ $hasSidebar ? 'lg:ml-64' : '' }}">
    <div class="flex items-center justify-between h-14 px-4 sm:px-6">
        <!-- Left: Logo + Title -->
        <div class="flex items-center gap-3">
            <img src="/marena-mark.svg" alt="" class="w-8 h-8">
            <h1 class="text-base font-semibold text-marena-teal-deep truncate">{{ $pageTitle }}</h1>
        </div>

        <!-- Right: Notifications + Profile -->
        <div class="flex items-center gap-2">
            <!-- Notifications -->
            <button x-data="{ open: false }" @click="open = !open" class="relative p-2 rounded-full hover:bg-marena-sage-mist transition-colors" aria-label="Notifications">
                <svg class="w-6 h-6 text-marena-ink-70" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                @if(auth()->check() && auth()->user()->unreadNotifications()->count() > 0)
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-marena-danger rounded-full ring-2 ring-marena-ivory"></span>
                @endif
            </button>

            <!-- Profile -->
            <a href="{{ route('settings') }}" class="flex items-center gap-2 p-1 rounded-full hover:bg-marena-sage-mist transition-colors">
                <div class="w-8 h-8 rounded-full bg-marena-teal text-white flex items-center justify-center text-sm font-semibold">
                    {{ auth()->check() ? strtoupper(auth()->user()->name[0] ?? 'U') : 'U' }}
                </div>
            </a>
        </div>
    </div>
</header>