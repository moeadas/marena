@extends('layouts.app', ['pageTitle' => 'Provider Onboarding'])

@section('bottom_nav')
    @include('partials.bottom-nav-provider', ['current' => 'dashboard'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ step: 1, totalSteps: 7 }">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-marena-teal-deep">Provider Onboarding</h1>
        <span class="text-sm text-marena-ink-50">Step {{ step }}/{{ totalSteps }}</span>
    </div>

    <div class="h-2 rounded-full bg-marena-ink-10 overflow-hidden">
        <div class="h-full bg-marena-teal transition-all duration-300" :style="`width: ${(step / totalSteps) * 100}%`"></div>
    </div>

    <!-- Step 1: Identity/Company -->
    <div x-show="step === 1" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Identity & Company</h2>
        <div><label class="label">Full Name</label><input type="text" class="input"></div>
        <div><label class="label">Professional Title</label><input type="text" class="input" placeholder="Registered Nurse"></div>
        <div><label class="label">Company Name</label><input type="text" class="input" placeholder="Independent or company name"></div>
        <div><label class="label">License Number</label><input type="text" class="input"></div>
        <button @click="step = 2" class="btn-primary w-full">Continue</button>
    </div>

    <!-- Step 2: Verification Docs -->
    <div x-show="step === 2" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Verification Documents</h2>
        <p class="text-sm text-marena-ink-50">Upload your professional credentials for verification.</p>
        @foreach(['Professional License', 'Malpractice Insurance', 'ID Document'] as $doc)
            <div class="card-tight border-2 border-dashed border-marena-ink-30 text-center py-6">
                <svg class="w-8 h-8 mx-auto mb-1 text-marena-ink-50" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                <span class="text-sm text-marena-ink-50">{{ $doc }}</span>
            </div>
        @endforeach
        <div class="flex gap-2">
            <button @click="step = 1" class="btn-outline flex-1">← Back</button>
            <button @click="step = 3" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 3: Services -->
    <div x-show="step === 3" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Your Services</h2>
        <p class="text-sm text-marena-ink-50">Select the services you offer.</p>
        <div class="grid grid-cols-2 gap-2">
            @foreach(['Nursing', 'Physiotherapy', 'Home Care', 'Medication', 'Wound Care', 'Palliative'] as $svc)
                <button class="rounded-xl border-2 border-marena-ink-10 px-3 py-3 text-sm text-marena-ink-70 hover:border-marena-teal transition-colors">{{ $svc }}</button>
            @endforeach
        </div>
        <div class="flex gap-2">
            <button @click="step = 2" class="btn-outline flex-1">← Back</button>
            <button @click="step = 4" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 4: Tariffs -->
    <div x-show="step === 4" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Tariffs & Pricing</h2>
        <div class="card space-y-3">
            <div class="flex justify-between items-center"><span class="text-sm text-marena-ink-70">Home Nursing (60 min)</span><input type="number" class="input w-24" placeholder="€45"></div>
            <div class="flex justify-between items-center"><span class="text-sm text-marena-ink-70">Physiotherapy (45 min)</span><input type="number" class="input w-24" placeholder="€55"></div>
        </div>
        <button class="btn-outline w-full">+ Add another service</button>
        <div class="flex gap-2">
            <button @click="step = 3" class="btn-outline flex-1">← Back</button>
            <button @click="step = 5" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 5: Funding -->
    <div x-show="step === 5" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Funding Options</h2>
        <p class="text-sm text-marena-ink-50">Which funding types do you accept?</p>
        <div class="space-y-2">
            @foreach(['Insurance', 'Government Subsidy', 'Private Pay', 'Grant Funded'] as $fund)
                <label class="card flex items-center justify-between">
                    <span class="text-sm text-marena-ink-70">{{ $fund }}</span>
                    <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
                </label>
            @endforeach
        </div>
        <div class="flex gap-2">
            <button @click="step = 4" class="btn-outline flex-1">← Back</button>
            <button @click="step = 6" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 6: Schedule -->
    <div x-show="step === 6" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Your Schedule</h2>
        <p class="text-sm text-marena-ink-50">Set your general availability.</p>
        <div class="card space-y-2">
            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" class="rounded text-marena-teal" @if(in_array($day, ['Monday','Tuesday','Wednesday','Thursday','Friday'])) checked @endif>
                        <span class="text-sm text-marena-ink-70">{{ $day }}</span>
                    </div>
                    <div class="flex gap-1 text-xs text-marena-ink-50">
                        <span>09:00</span><span>–</span><span>17:00</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-2">
            <button @click="step = 5" class="btn-outline flex-1">← Back</button>
            <button @click="step = 7" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 7: Billing -->
    <div x-show="step === 7" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Billing Setup</h2>
        <div><label class="label">IBAN</label><input type="text" class="input" placeholder="ES.."></div>
        <div><label class="label">Bank Name</label><input type="text" class="input"></div>
        <div><label class="label">Tax ID / VAT</label><input type="text" class="input"></div>
        <div><label class="label">Invoice Email</label><input type="email" class="input"></div>
        <div class="flex gap-2">
            <button @click="step = 6" class="btn-outline flex-1">← Back</button>
            <button class="btn-primary flex-1">Complete Setup</button>
        </div>
    </div>
</div>
@endsection