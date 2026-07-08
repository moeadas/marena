@extends('layouts.app', ['pageTitle' => 'Getting Started'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'home'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ step: 1, totalSteps: 8 }">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-marena-teal-deep">Welcome to MARÉNA Care</h1>
        <span class="text-sm text-marena-ink-50">Step {{ step }}/{{ totalSteps }}</span>
    </div>

    <!-- Progress bar -->
    <div class="h-2 rounded-full bg-marena-ink-10 overflow-hidden">
        <div class="h-full bg-marena-teal transition-all duration-300" :style="`width: ${(step / totalSteps) * 100}%`"></div>
    </div>

    <!-- Step 1: Personal Info -->
    <div x-show="step === 1" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Personal Information</h2>
        <div><label class="label">Full Name</label><input type="text" class="input" placeholder="Jane Doe"></div>
        <div><label class="label">Date of Birth</label><input type="date" class="input"></div>
        <div><label class="label">Gender</label>
            <select class="input"><option>Female</option><option>Male</option><option>Other</option><option>Prefer not to say</option></select>
        </div>
        <div><label class="label">National ID / Passport</label><input type="text" class="input"></div>
        <button @click="step = 2" class="btn-primary w-full">Continue</button>
    </div>

    <!-- Step 2: Address -->
    <div x-show="step === 2" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Your Address</h2>
        <div><label class="label">Street Address</label><input type="text" class="input" placeholder="Carrer Major 12"></div>
        <div><label class="label">City</label><input type="text" class="input" placeholder="Palma"></div>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="label">Postal Code</label><input type="text" class="input" placeholder="07001"></div>
            <div><label class="label">Country</label><input type="text" class="input" placeholder="Spain"></div>
        </div>
        <div class="flex gap-2">
            <button @click="step = 1" class="btn-outline flex-1">← Back</button>
            <button @click="step = 3" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 3: Emergency Contacts -->
    <div x-show="step === 3" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Emergency Contacts</h2>
        <p class="text-sm text-marena-ink-50">Add people we should contact in case of emergency.</p>
        <div><label class="label">Contact Name</label><input type="text" class="input"></div>
        <div><label class="label">Relationship</label><input type="text" class="input" placeholder="Spouse, Child, Friend..."></div>
        <div><label class="label">Phone Number</label><input type="tel" class="input" placeholder="+34 ..."></div>
        <button class="btn-outline w-full">+ Add another contact</button>
        <div class="flex gap-2">
            <button @click="step = 2" class="btn-outline flex-1">← Back</button>
            <button @click="step = 4" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 4: Preferences -->
    <div x-show="step === 4" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Preferences</h2>
        <div><label class="label">Preferred Language</label><select class="input"><option>English</option><option>Español</option><option>Français</option></select></div>
        <div><label class="label">Communication Preference</label><select class="input"><option>App notifications</option><option>SMS</option><option>Email</option><option>Phone call</option></select></div>
        <div class="card flex items-center justify-between">
            <span class="text-sm text-marena-ink-70">I prefer morning visits</span>
            <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
        </div>
        <div class="flex gap-2">
            <button @click="step = 3" class="btn-outline flex-1">← Back</button>
            <button @click="step = 5" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 5: Care Needs -->
    <div x-show="step === 5" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Your Care Needs</h2>
        <p class="text-sm text-marena-ink-50">What kind of care do you need?</p>
        <div class="grid grid-cols-2 gap-2">
            @foreach(['Nursing', 'Physiotherapy', 'Home Care', 'Medication', 'Transport', 'Companionship'] as $need)
                <button class="rounded-xl border-2 border-marena-ink-10 px-3 py-3 text-sm text-marena-ink-70 hover:border-marena-teal transition-colors">{{ $need }}</button>
            @endforeach
        </div>
        <div class="flex gap-2">
            <button @click="step = 4" class="btn-outline flex-1">← Back</button>
            <button @click="step = 6" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 6: Providers -->
    <div x-show="step === 6" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Your Providers</h2>
        <p class="text-sm text-marena-ink-50">Link your existing healthcare providers.</p>
        <div class="card flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-marena-sage-mist flex items-center justify-center text-sm font-semibold text-marena-teal-deep">D</div>
            <div class="flex-1"><p class="text-sm font-medium">Dr. Smith</p><p class="text-xs text-marena-ink-50">General Practitioner</p></div>
            <button class="btn-sm btn-outline">Link</button>
        </div>
        <button class="btn-outline w-full">+ Add provider</button>
        <div class="flex gap-2">
            <button @click="step = 5" class="btn-outline flex-1">← Back</button>
            <button @click="step = 7" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 7: Caregiver Access -->
    <div x-show="step === 7" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Caregiver Access</h2>
        <p class="text-sm text-marena-ink-50">Grant a caregiver access to help manage your care.</p>
        <div><label class="label">Caregiver Email</label><input type="email" class="input" placeholder="caregiver@example.com"></div>
        <div><label class="label">Access Level</label><select class="input"><option>Full access</option><option>Schedule only</option><option>Messages only</option><option>View only</option></select></div>
        <button class="btn-outline w-full">Skip for now</button>
        <div class="flex gap-2">
            <button @click="step = 6" class="btn-outline flex-1">← Back</button>
            <button @click="step = 8" class="btn-primary flex-1">Continue</button>
        </div>
    </div>

    <!-- Step 8: Consent -->
    <div x-show="step === 8" x-transition class="space-y-4">
        <h2 class="text-lg font-semibold text-marena-teal-deep">Consent & Privacy</h2>
        <div class="card space-y-3">
            <label class="flex items-start gap-2">
                <input type="checkbox" class="mt-1 rounded text-marena-teal">
                <span class="text-sm text-marena-ink-70">I consent to share my health data with my care circle for coordination purposes.</span>
            </label>
            <label class="flex items-start gap-2">
                <input type="checkbox" class="mt-1 rounded text-marena-teal">
                <span class="text-sm text-marena-ink-70">I agree to the Terms of Service and Privacy Policy.</span>
            </label>
            <label class="flex items-start gap-2">
                <input type="checkbox" class="mt-1 rounded text-marena-teal">
                <span class="text-sm text-marena-ink-70">I consent to receive care reminders and notifications.</span>
            </label>
        </div>
        <div class="flex gap-2">
            <button @click="step = 7" class="btn-outline flex-1">← Back</button>
            <button class="btn-primary flex-1">Complete Setup</button>
        </div>
    </div>
</div>
@endsection