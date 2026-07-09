@props([
    'icon' => 'M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4',
    'title' => '',
    'cta' => '',
    'ctaRoute' => '',
])

<div class="flex flex-col items-center justify-center text-center py-12 px-4 mfade">
    <div class="w-16 h-16 rounded-full bg-marena-sage-mist flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-marena-teal-soft" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            @foreach(explode(';', $icon) as $path)
                <path d="{{ trim($path) }}"/>
            @endforeach
        </svg>
    </div>
    @if($title)
        <p class="text-base font-medium text-marena-ink-70 mb-1">{{ $title }}</p>
    @endif
    @isset($slot)
        <p class="text-sm text-marena-ink-50 mb-4 max-w-xs">{{ $slot }}</p>
    @endisset
    @if($cta && $ctaRoute)
        <a href="{{ $ctaRoute }}" class="btn-primary">{{ $cta }}</a>
    @endif
</div>