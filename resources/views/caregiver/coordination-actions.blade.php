@extends('layouts.app', ['pageTitle' => 'Coordination Actions'])

@section('bottom_nav')
    @include('partials.bottom-nav-caregiver', ['current' => 'home'])
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Coordination Actions</h1>
    <p class="text-sm text-marena-ink-50 -mt-3">Manage and coordinate care services.</p>

    <!-- Action Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        @php
            $actions = [
                ['label' => 'Request New Provider', 'icon' => 'M12 5v14M5 12h14', 'route' => '#'],
                ['label' => 'Change Schedule', 'icon' => 'M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z', 'route' => '#'],
                ['label' => 'Pause Service', 'icon' => 'M10 9v6l6-3V6z;M10 9v6', 'route' => '#'],
                ['label' => 'Add Care Need', 'icon' => 'M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4', 'route' => '#'],
                ['label' => 'Contact Admin', 'icon' => 'M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z;M22 6l-10 7L2 6', 'route' => '#'],
                ['label' => 'Upload Document', 'icon' => 'M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4;M17 8l-5-5-5 5;M12 3v12', 'route' => '#'],
            ];
        @endphp
        @foreach($actions as $action)
            <a href="{{ $action['route'] }}" class="card flex items-center gap-3 hover:bg-marena-sage-mist transition-colors">
                <div class="w-10 h-10 rounded-xl bg-marena-sage-mist flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        @foreach(explode(';', $action['icon']) as $path)
                            <path d="{{ $path }}"/>
                        @endforeach
                    </svg>
                </div>
                <span class="text-sm font-medium text-marena-ink-70">{{ $action['label'] }}</span>
                <svg class="w-5 h-5 text-marena-ink-30 ml-auto" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
            </a>
        @endforeach
    </div>
</div>
@endsection