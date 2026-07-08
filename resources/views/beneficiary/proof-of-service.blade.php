@extends('layouts.app', ['pageTitle' => 'Proof of Service'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'schedule'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Proof of Service</h1>

    @if(isset($intervention))
    <!-- Service Info -->
    <div class="card">
        <p class="text-sm text-marena-ink-50">{{ $intervention->scheduled_at?->format('l, M j, Y · H:i') ?? '' }}</p>
        <p class="font-medium text-marena-ink mt-1">{{ $intervention->service?->name ?? 'Service' }}</p>
        <p class="text-sm text-marena-ink-50">{{ $intervention->provider?->name ?? '' }}</p>
        <div class="mt-2"><x-status-badge :status="$intervention->status ?? 'completed'" /></div>
    </div>

    <!-- Checklist -->
    <div>
        <x-section-header title="Checklist" />
        <div class="space-y-2">
            @if(isset($checklist) && count($checklist) > 0)
                @foreach($checklist as $item)
                    <div class="card-tight flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full {{ $item['done'] ? 'bg-marena-success' : 'border-2 border-marena-ink-30' }} flex items-center justify-center flex-shrink-0">
                            @if($item['done'])
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </div>
                        <span class="flex-1 text-sm {{ $item['done'] ? 'text-marena-ink-50 line-through' : 'text-marena-ink-70' }}">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            @else
                <div class="card-tight text-sm text-marena-ink-50 text-center py-4">No checklist items</div>
            @endif
        </div>
    </div>

    <!-- Photos -->
    @if(isset($photos) && count($photos) > 0)
    <div>
        <x-section-header title="Photos" />
        <div class="grid grid-cols-3 gap-2">
            @foreach($photos as $photo)
                <div class="aspect-square rounded-xl overflow-hidden bg-marena-sage-mist">
                    <img src="{{ $photo }}" alt="" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Notes -->
    @if(isset($notes) && $notes)
    <div>
        <x-section-header title="Provider Notes" />
        <div class="card">
            <p class="text-sm text-marena-ink-70">{{ $notes }}</p>
        </div>
    </div>
    @endif

    <!-- Feedback -->
    <div>
        <x-section-header title="Your Feedback" />
        <div class="card space-y-4">
            <div x-data="{ rating: 0 }">
                <label class="label">How was your experience?</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" @click="rating = {{ $i }}" :class="rating >= {{ $i }} ? 'text-marena-tan' : 'text-marena-ink-30'" class="text-3xl">
                            ★
                        </button>
                    @endfor
                </div>
            </div>
            <div>
                <label class="label">Comments</label>
                <textarea rows="3" class="input" placeholder="Share your experience..."></textarea>
            </div>
            <button class="btn-primary w-full">Submit Feedback</button>
        </div>
    </div>

    <!-- Flag Issue -->
    <div>
        <button class="btn-danger w-full">Flag an Issue</button>
    </div>
    @else
    <div class="card">
        <x-empty-state icon="M9 11l3 3L22 4;M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" title="No intervention selected" />
    </div>
    @endif
</div>
@endsection