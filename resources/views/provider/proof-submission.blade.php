@extends('layouts.app', ['pageTitle' => 'Proof of Service'])

@section('bottom_nav')
    @include('partials.bottom-nav-provider', ['current' => 'dashboard'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Proof of Service Submission</h1>

    <!-- Visit Info -->
    <div class="card">
        <p class="text-sm text-marena-ink-50">Visit completed on {{ now()->format('M j, Y · H:i') }}</p>
        <p class="font-medium text-marena-ink mt-1">{{ $service ?? 'Home Nursing' }}</p>
        <p class="text-sm text-marena-ink-50">{{ $beneficiary ?? 'Maria Lopez' }}</p>
    </div>

    <!-- Completed Checklist -->
    <div>
        <x-section-header title="Completed Checklist" />
        <div class="space-y-2">
            @foreach(['Check vital signs', 'Administer medication', 'Wound dressing', 'Document observations'] as $item)
                <div class="card-tight flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full bg-marena-success flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-sm text-marena-ink-70">{{ $item }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Notes -->
    <div>
        <x-section-header title="Service Notes" />
        <div class="card">
            <textarea rows="4" class="input" placeholder="Summarize the visit, observations, and outcomes..."></textarea>
        </div>
    </div>

    <!-- Photos -->
    <div>
        <x-section-header title="Photos" />
        <button class="card-tight w-full border-2 border-dashed border-marena-ink-30 text-center py-6 hover:border-marena-teal transition-colors">
            <svg class="w-8 h-8 mx-auto mb-1 text-marena-ink-50" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            <span class="text-sm text-marena-ink-50">Attach photos</span>
        </button>
    </div>

    <!-- Signature -->
    <div>
        <x-section-header title="Signature" />
        <div class="card">
            <div class="bg-white rounded-lg border border-marena-ink-10 h-32 flex items-center justify-center">
                <p class="text-sm text-marena-ink-50">Sign here with your finger</p>
            </div>
        </div>
    </div>

    <!-- Service Outcome -->
    <div>
        <x-section-header title="Service Outcome" />
        <div class="card space-y-3">
            <label class="flex items-center gap-2"><input type="radio" name="outcome" class="text-marena-teal" checked> <span class="text-sm text-marena-ink-70">Completed successfully</span></label>
            <label class="flex items-center gap-2"><input type="radio" name="outcome" class="text-marena-teal"> <span class="text-sm text-marena-ink-70">Partially completed</span></label>
            <label class="flex items-center gap-2"><input type="radio" name="outcome" class="text-marena-teal"> <span class="text-sm text-marena-ink-70">Could not complete</span></label>
        </div>
    </div>

    <!-- Recommend Next Action -->
    <div>
        <x-section-header title="Recommend Next Action" />
        <div class="card">
            <select class="input">
                <option>Schedule follow-up visit</option>
                <option>No follow-up needed</option>
                <option>Refer to specialist</option>
                <option>Adjust care plan</option>
            </select>
        </div>
    </div>

    <button class="btn-primary btn-lg w-full">Submit Proof of Service</button>
</div>
@endsection