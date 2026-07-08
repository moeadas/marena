@extends('layouts.app', ['pageTitle' => 'Reviews'])

@section('bottom_nav')
    @include('partials.bottom-nav-provider', ['current' => 'profile'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Reviews & Feedback</h1>

    <!-- Rating Summary -->
    <div class="card text-center">
        <p class="text-5xl font-semibold text-marena-teal-deep">{{ $avgRating ?? '4.8' }}</p>
        <div class="text-marena-tan text-2xl mt-1">★★★★★</div>
        <p class="text-sm text-marena-ink-50 mt-1">Based on {{ $totalReviews ?? 0 }} reviews</p>
    </div>

    <!-- Rating Breakdown -->
    <div class="card space-y-2">
        @for($star = 5; $star >= 1; $star--)
            <div class="flex items-center gap-3">
                <span class="text-sm text-marena-ink-50 w-8">{{ $star }}★</span>
                <div class="flex-1 h-2 rounded-full bg-marena-ink-10 overflow-hidden">
                    <div class="h-full bg-marena-tan" style="width: {{ $star === 5 ? 75 : ($star === 4 ? 20 : ($star === 3 ? 4 : 1)) }}%"></div>
                </div>
                <span class="text-xs text-marena-ink-50 w-8 text-right">{{ $star === 5 ? 75 : ($star === 4 ? 20 : ($star === 3 ? 4 : 1)) }}%</span>
            </div>
        @endfor
    </div>

    <!-- Comments -->
    @if(isset($reviews) && $reviews->count() > 0)
        <div>
            <x-section-header title="Recent Reviews" />
            <div class="space-y-3">
                @foreach($reviews as $review)
                    <div class="card">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-full bg-marena-sage-mist flex items-center justify-center text-xs font-semibold text-marena-teal-deep">
                                {{ strtoupper($review->user[0] ?? '?') }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-marena-ink">{{ $review->user ?? 'Anonymous' }}</p>
                                <p class="text-xs text-marena-ink-50">{{ $review->created_at?->diffForHumans() ?? '' }}</p>
                            </div>
                            <div class="ml-auto text-marena-tan text-sm">{{ str_repeat('★', $review->rating ?? 5) }}</div>
                        </div>
                        <p class="text-sm text-marena-ink-70">{{ $review->comment ?? '' }}</p>
                        @if($review->disputed ?? false)
                            <div class="mt-2"><span class="badge-missed">Disputed</span></div>
                        @else
                            <button class="btn-sm btn-ghost text-marena-danger mt-2">Dispute this review</button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4" title="No reviews yet" />
        </div>
    @endif
</div>
@endsection