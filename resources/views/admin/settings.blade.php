@extends('layouts.app', ['pageTitle' => 'Settings'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'settings'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'profile' }">
    <h1 class="text-2xl font-semibold text-marena-teal-deep">Admin Settings</h1>

    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-1">
        @foreach(['profile' => 'Profile', 'system' => 'System', 'notifications' => 'Notifications'] as $key => $label)
            <button @click="activeTab = '{{ $key }}'" :class="activeTab === '{{ $key }}' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'" class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all">{{ $label }}</button>
        @endforeach
    </div>

    <div x-show="activeTab === 'profile'" x-transition class="card space-y-4">
        <div><label class="label">Name</label><input type="text" class="input" value="{{ $user->name ?? '' }}"></div>
        <div><label class="label">Email</label><input type="email" class="input" value="{{ $user->email ?? '' }}"></div>
        <button class="btn-primary w-full">Save Changes</button>
    </div>

    <div x-show="activeTab === 'system'" x-transition class="space-y-3">
        <div class="card flex items-center justify-between">
            <div><p class="text-sm font-medium text-marena-ink">Maintenance Mode</p><p class="text-xs text-marena-ink-50">Take platform offline temporarily</p></div>
            <input type="checkbox" class="w-6 h-6 rounded text-marena-teal">
        </div>
        <div class="card flex items-center justify-between">
            <div><p class="text-sm font-medium text-marena-ink">Auto-approve providers</p><p class="text-xs text-marena-ink-50">Skip manual verification</p></div>
            <input type="checkbox" class="w-6 h-6 rounded text-marena-teal">
        </div>
    </div>

    <div x-show="activeTab === 'notifications'" x-transition class="space-y-3">
        @foreach(['New provider registration', 'New complaint filed', 'Matching request opened', 'Weekly summary'] as $setting)
            <div class="card flex items-center justify-between">
                <span class="text-sm text-marena-ink-70">{{ $setting }}</span>
                <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
            </div>
        @endforeach
    </div>
</div>
@endsection