@extends('layouts.app', ['pageTitle' => 'Request Service'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'home'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ urgency: 'normal', showCustom: false }">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Request a Service</h1>
    <p class="text-sm text-marena-ink-50 -mt-3">Choose what you need and we'll match you with the right care.</p>

    <!-- Category Grid -->
    <div>
        <x-section-header title="What do you need?" />
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @php
                $categories = [
                    ['label' => 'Nursing', 'icon' => 'M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4'],
                    ['label' => 'Physiotherapy', 'icon' => 'M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z;M3 6h18M16 2v4M8 2v4'],
                    ['label' => 'Home Care', 'icon' => 'M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z;M9 22V12h6v10'],
                    ['label' => 'Doctor Visit', 'icon' => 'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2;circle cx=12 cy=7 r=4'],
                    ['label' => 'Medication', 'icon' => 'M10.5 15l1.5 1.5L17 12M3 12l1.5 1.5L8 10M3 3v18h18'],
                    ['label' => 'Transport', 'icon' => 'M16 3h-2v14h2V3zM9 7h2v10H9V7zM3 11h2v6H3v-6zM18 13v6h2v-6h-2z'],
                ];
            @endphp
            @foreach($categories as $cat)
                <button class="card flex flex-col items-center gap-2 hover:border-marena-teal hover:bg-marena-sage-mist transition-colors border-2 border-transparent">
                    <svg class="w-8 h-8 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        @foreach(explode(';', $cat['icon']) as $path)
                            <path d="{{ $path }}"/>
                        @endforeach
                    </svg>
                    <span class="text-sm font-medium text-marena-ink-70">{{ $cat['label'] }}</span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Custom Need -->
    <div>
        <button @click="showCustom = !showCustom" class="btn-outline w-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Describe a custom need
        </button>
        <div x-show="showCustom" x-transition class="mt-3">
            <textarea rows="3" class="input" placeholder="Tell us what you need..."></textarea>
        </div>
    </div>

    <!-- Urgency Selector -->
    <div>
        <label class="label">How urgent is this?</label>
        <div class="grid grid-cols-3 gap-2">
            <button @click="urgency = 'normal'" :class="urgency === 'normal' ? 'bg-marena-teal text-white border-marena-teal' : 'bg-marena-ivory text-marena-ink-50 border-marena-ink-10'" class="rounded-xl border-2 py-3 text-sm font-medium transition-all">
                Normal
            </button>
            <button @click="urgency = 'soon'" :class="urgency === 'soon' ? 'bg-marena-warn text-white border-marena-warn' : 'bg-marena-ivory text-marena-ink-50 border-marena-ink-10'" class="rounded-xl border-2 py-3 text-sm font-medium transition-all">
                This Week
            </button>
            <button @click="urgency = 'urgent'" :class="urgency === 'urgent' ? 'bg-marena-danger text-white border-marena-danger' : 'bg-marena-ivory text-marena-ink-50 border-marena-ink-10'" class="rounded-xl border-2 py-3 text-sm font-medium transition-all">
                Urgent
            </button>
        </div>
    </div>

    <!-- Funding Preference -->
    <div>
        <label class="label">Funding preference</label>
        <select class="input">
            <option value="">No preference</option>
            <option value="insurance">Insurance covered</option>
            <option value="subsidized">Subsidized care</option>
            <option value="private">Private pay</option>
            <option value="grant">Grant funded</option>
        </select>
    </div>

    <button class="btn-primary w-full btn-lg">Submit Request</button>
</div>
@endsection