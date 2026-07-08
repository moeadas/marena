@extends('layouts.app', ['pageTitle' => 'Provider Verification'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'approvals'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-semibold text-marena-teal-deep">Provider Verification</h1>

    <!-- Profile Summary -->
    <div class="card flex items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-marena-sage-mist flex items-center justify-center text-xl font-semibold text-marena-teal-deep">
            {{ strtoupper($provider->name[0] ?? 'P') }}
        </div>
        <div class="flex-1">
            <h2 class="text-lg font-semibold text-marena-teal-deep">{{ $provider->name ?? 'Provider' }}</h2>
            <p class="text-sm text-marena-ink-50">{{ $provider->title ?? '' }} &middot; {{ $provider->company ?? 'Independent' }}</p>
            <div class="mt-1"><span class="badge-pending">Pending Verification</span></div>
        </div>
    </div>

    <!-- Uploaded Documents -->
    <div>
        <x-section-header title="Uploaded Documents" />
        <div class="space-y-2">
            @foreach(['Professional License', 'Malpractice Insurance', 'ID Document'] as $doc)
                <div class="card-tight flex items-center gap-3">
                    <svg class="w-5 h-5 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-marena-ink">{{ $doc }}</p>
                        <p class="text-xs text-marena-ink-50">Uploaded {{ now()->subDays(rand(1,30))->diffForHumans() }}</p>
                    </div>
                    <button class="btn-sm btn-secondary">View</button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Verification Notes -->
    <div>
        <x-section-header title="Verification Notes" />
        <div class="card">
            <textarea rows="4" class="input" placeholder="Add verification notes..."></textarea>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-2">
        <button class="btn-primary flex-1">Approve Provider</button>
        <button class="btn-outline flex-1 text-marena-danger border-marena-danger/30">Reject</button>
        <button class="btn-secondary flex-1">Request More Info</button>
    </div>
</div>
@endsection