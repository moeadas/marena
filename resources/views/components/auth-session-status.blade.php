@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-marena-success']) }}>
        {{ $status }}
    </div>
@endif