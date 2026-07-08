@extends('layouts.app', ['pageTitle' => 'Visit Execution'])

@section('bottom_nav')
    @include('partials.bottom-nav-provider', ['current' => 'dashboard'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ started: false, elapsed: '00:00:00' }">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Visit Execution</h1>

    <!-- Beneficiary Info -->
    <div class="card">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-marena-sage-mist flex items-center justify-center font-semibold text-marena-teal-deep">M</div>
            <div class="flex-1">
                <p class="font-medium text-sm text-marena-ink">{{ $beneficiary->name ?? 'Maria Lopez' }}</p>
                <p class="text-xs text-marena-ink-50">{{ $service ?? 'Home Nursing' }} &middot; {{ $scheduledTime ?? '10:00' }}</p>
            </div>
        </div>
    </div>

    <!-- Timer / Start -->
    <div class="card text-center" x-show="!started">
        <p class="text-sm text-marena-ink-50 mb-3">Ready to start your visit?</p>
        <button @click="started = true" class="btn-primary btn-lg w-full">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            Start Visit
        </button>
    </div>

    <!-- Active Visit -->
    <div x-show="started" x-transition class="space-y-4">
        <!-- Timer -->
        <div class="card text-center bg-marena-teal text-white">
            <p class="text-xs uppercase tracking-wide text-marena-sage-light">Visit in progress</p>
            <p class="text-4xl font-semibold mt-1" x-text="elapsed">00:00:00</p>
            <button @click="started = false" class="mt-3 bg-white text-marena-teal rounded-xl px-4 py-2 text-sm font-medium">Pause</button>
        </div>

        <!-- Checklist -->
        <div>
            <x-section-header title="Checklist" />
            <div class="space-y-2">
                @php
                    $checklistItems = [
                        'Check vital signs',
                        'Administer medication',
                        'Wound dressing change',
                        'Document observations',
                        'Update care notes',
                    ];
                @endphp
                @foreach($checklistItems as $item)
                    <div class="card-tight flex items-center gap-3" x-data="{ done: false }" @click="done = !done">
                        <div class="w-6 h-6 rounded-full flex-shrink-0 cursor-pointer" :class="done ? 'bg-marena-success' : 'border-2 border-marena-ink-30'">
                            <template x-if="done"><svg class="w-6 h-6 text-white p-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg></template>
                        </div>
                        <span class="flex-1 text-sm cursor-pointer" :class="done ? 'text-marena-ink-50 line-through' : 'text-marena-ink-70'" x-text="'{{ $item }}'">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Comments -->
        <div>
            <x-section-header title="Comments" />
            <textarea rows="3" class="input" placeholder="Add visit notes..."></textarea>
        </div>

        <!-- Photos -->
        <div>
            <x-section-header title="Photos" />
            <button class="card-tight w-full border-2 border-dashed border-marena-ink-30 text-center py-6 text-marena-ink-50 hover:border-marena-teal transition-colors">
                <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                <span class="text-sm">Tap to add photos</span>
            </button>
        </div>

        <!-- Flag Issue -->
        <button class="btn-outline w-full text-marena-danger border-marena-danger/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
            Flag an Issue
        </button>

        <!-- Complete -->
        <button class="btn-primary btn-lg w-full">Complete Visit</button>
    </div>
</div>
@endsection