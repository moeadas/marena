@extends('layouts.guest')

@section('content')
<div class="text-center space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-marena-teal-deep">Welcome to MARÉNA Care</h1>
        <p class="text-marena-ink-50 mt-2 max-w-md mx-auto">Care coordination, simplified. Connecting beneficiaries, caregivers, and providers in one calm, trusted platform.</p>
    </div>

    <div class="flex flex-col gap-3">
        <a href="{{ route('login') }}" class="btn-primary btn-lg w-full">Sign in</a>
        <a href="{{ route('register') }}" class="btn-outline btn-lg w-full">Create account</a>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-8 max-w-sm mx-auto">
        @foreach([
            ['icon' => 'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2;circle cx=12 cy=7 r=4', 'label' => 'Person-centered'],
            ['icon' =>M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2;circle cx=9 cy=7 r=4;M23 21v-2a4 4 0 0 0-3-3.87;M16 3.13a4 4 0 0 1 0 7.75', 'label' => 'Coordinated'],
            ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', 'label' => 'Secure'],
        ] as $feature)
            <div class="flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-xl bg-marena-sage-mist flex items-center justify-center">
                    <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        @foreach(explode(';', $feature['icon']) as $path)
                            <path d="{{ $path }}"/>
                        @endforeach
                    </svg>
                </div>
                <span class="text-xs text-marena-ink-50">{{ $feature['label'] }}</span>
            </div>
        @endforeach
    </div>
</div>
@endsection