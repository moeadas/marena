@extends('layouts.app', ['pageTitle' => 'Matching Requests'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'matching'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-semibold text-marena-teal-deep">Matching Requests</h1>

    @if(isset($requests) && $requests->count() > 0)
        <div class="space-y-4">
            @foreach($requests as $request)
                <div class="card">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-marena-warn/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-marena-warn" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-marena-ink">{{ $request->beneficiary ?? 'Beneficiary' }}</p>
                            <p class="text-xs text-marena-ink-50">{{ $request->service_type ?? '' }} &middot; {{ $request->urgency ?? 'Normal' }} &middot; {{ $request->created_at?->diffForHumans() ?? '' }}</p>
                        </div>
                        <x-status-badge :status="$request->status ?? 'pending'" />
                    </div>

                    <!-- Suggested Providers -->
                    <div class="border-t border-marena-ink-10 pt-3">
                        <p class="text-xs font-medium text-marena-ink-50 mb-2">SUGGESTED PROVIDERS</p>
                        <div class="space-y-2">
                            @if(isset($request->suggestions))
                                @foreach($request->suggestions as $suggestion)
                                    <div class="flex items-center gap-3 p-2 rounded-lg bg-marena-sage-mist/30">
                                        <div class="w-8 h-8 rounded-full bg-marena-sage-mist flex items-center justify-center text-xs font-semibold text-marena-teal-deep">
                                            {{ strtoupper($suggestion['name'][0] ?? '?') }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-marena-ink truncate">{{ $suggestion['name'] ?? 'Provider' }}</p>
                                            <p class="text-xs text-marena-ink-50">{{ $suggestion['match_score'] ?? '85%' }} match &middot; {{ $suggestion['distance'] ?? '2.5km' }}</p>
                                        </div>
                                        <button class="btn-sm btn-primary">Assign</button>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-xs text-marena-ink-50 text-center py-2">No suggestions available</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2;circle cx=9 cy=7 r=4" title="No open matching requests" />
        </div>
    @endif
</div>
@endsection