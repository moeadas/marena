@extends('layouts.app', ['pageTitle' => 'Settings'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'profile'])
@endsection

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'profile' }">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Settings</h1>

    <!-- Tabs -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-1">
        @php
            $tabs = [
                ['key' => 'profile', 'label' => 'Profile'],
                ['key' => 'privacy', 'label' => 'Privacy'],
                ['key' => 'notifications', 'label' => 'Notifications'],
                ['key' => 'language', 'label' => 'Language'],
                ['key' => 'data', 'label' => 'Data Management'],
            ];
        @endphp
        @foreach($tabs as $tab)
            <button @click="activeTab = '{{ $tab['key'] }}'"
                :class="activeTab === '{{ $tab['key'] }}' ? 'bg-marena-teal text-white' : 'bg-marena-ivory text-marena-ink-50 border border-marena-ink-10'"
                class="flex-shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all">
                {{ $tab['label'] }}
            </button>
        @endforeach
    </div>

    <!-- Profile -->
    <div x-show="activeTab === 'profile'" x-transition class="space-y-4">
        <div class="card flex flex-col items-center gap-3 pb-6">
            <div class="w-20 h-20 rounded-full bg-marena-teal text-white flex items-center justify-center text-2xl font-semibold">
                {{ strtoupper(auth()->user()->name[0] ?? 'U') }}
            </div>
            <button class="btn-sm btn-outline">Change Photo</button>
        </div>
        <div class="card space-y-4">
            <div><label class="label">Full Name</label><input type="text" class="input" value="{{ auth()->user()->name ?? '' }}"></div>
            <div><label class="label">Email</label><input type="email" class="input" value="{{ auth()->user()->email ?? '' }}"></div>
            <div><label class="label">Phone</label><input type="tel" class="input" placeholder="+34 ..."></div>
            <div><label class="label">Address</label><input type="text" class="input" placeholder="Street, City"></div>
            <button class="btn-primary w-full">Save Changes</button>
        </div>
    </div>

    <!-- Privacy -->
    <div x-show="activeTab === 'privacy'" x-transition class="space-y-3">
        <div class="card flex items-center justify-between">
            <div><p class="text-sm font-medium text-marena-ink">Share with Care Circle</p><p class="text-xs text-marena-ink-50">Allow members to see your health data</p></div>
            <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
        </div>
        <div class="card flex items-center justify-between">
            <div><p class="text-sm font-medium text-marena-ink">Anonymized Analytics</p><p class="text-xs text-marena-ink-50">Help improve care for everyone</p></div>
            <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
        </div>
        <div class="card flex items-center justify-between">
            <div><p class="text-sm font-medium text-marena-ink">Direct Messaging</p><p class="text-xs text-marena-ink-50">Allow providers to message you</p></div>
            <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
        </div>
    </div>

    <!-- Notifications -->
    <div x-show="activeTab === 'notifications'" x-transition class="space-y-3">
        @php
            $notifSettings = [
                ['label' => 'Appointment Reminders', 'desc' => 'Get notified before scheduled visits'],
                ['label' => 'New Messages', 'desc' => 'When you receive a new message'],
                ['label' => 'Alerts', 'desc' => 'Critical and high severity alerts'],
                ['label' => 'Weekly Summary', 'desc' => 'A summary of your week, every Sunday'],
            ];
        @endphp
        @foreach($notifSettings as $setting)
            <div class="card flex items-center justify-between">
                <div><p class="text-sm font-medium text-marena-ink">{{ $setting['label'] }}</p><p class="text-xs text-marena-ink-50">{{ $setting['desc'] }}</p></div>
                <input type="checkbox" class="w-6 h-6 rounded text-marena-teal" checked>
            </div>
        @endforeach
    </div>

    <!-- Language -->
    <div x-show="activeTab === 'language'" x-transition>
        <div class="card">
            <label class="label">Language</label>
            <select class="input">
                <option>English</option>
                <option>Español</option>
                <option>Français</option>
                <option>Italiano</option>
                <option>Português</option>
            </select>
        </div>
    </div>

    <!-- Data Management -->
    <div x-show="activeTab === 'data'" x-transition class="space-y-3">
        <a href="{{ route('backup.export') }}" class="card flex items-center gap-3 hover:bg-marena-sage-mist transition-colors">
            <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
            <div class="flex-1"><p class="text-sm font-medium text-marena-ink">Export My Data</p><p class="text-xs text-marena-ink-50">Download a backup of all your data</p></div>
        </a>
        <a href="{{ route('backup.import') }}" class="card flex items-center gap-3 hover:bg-marena-sage-mist transition-colors">
            <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
            <div class="flex-1"><p class="text-sm font-medium text-marena-ink">Import Data</p><p class="text-xs text-marena-ink-50">Restore from a backup file</p></div>
        </a>
        <a href="{{ route('backup.delete') }}" class="card flex items-center gap-3 hover:bg-marena-danger/5 transition-colors" onclick="return confirm('Are you sure? This cannot be undone.')">
            <svg class="w-6 h-6 text-marena-danger" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            <div class="flex-1"><p class="text-sm font-medium text-marena-danger">Delete My Account</p><p class="text-xs text-marena-ink-50">Permanently remove all your data</p></div>
        </a>
    </div>
</div>
@endsection