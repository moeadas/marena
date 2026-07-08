@props([
    'title' => '',
    'actionLabel' => '',
    'actionRoute' => '',
])

<div class="flex items-center justify-between mb-4">
    <h2 class="section-title">{{ $title }}</h2>
    @if($actionLabel && $actionRoute)
        <a href="{{ $actionRoute }}" class="btn-sm btn-outline">{{ $actionLabel }}</a>
    @endif
</div>