@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-marena-teal-deep mb-6">Settings</h1>

    <div class="space-y-3">
        <a href="{{ route('settings.profile') }}" class="card flex items-center justify-between hover:shadow-elevated transition-shadow">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="font-medium">Profile</span>
            </div>
            <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>

        <a href="{{ route('settings.password') }}" class="card flex items-center justify-between hover:shadow-elevated transition-shadow">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8.5-8 9-4.5-.5-8-4-8-9V6l8-3z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="font-medium">Password</span>
            </div>
            <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>

        <a href="{{ route('settings.notifications') }}" class="card flex items-center justify-between hover:shadow-elevated transition-shadow">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 8a6 6 0 1 1 12 0c0 5 2 6 2 6H4s2-1 2-6z" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 20a2 2 0 0 0 4 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="font-medium">Notifications</span>
            </div>
            <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>

        <a href="{{ route('settings.privacy') }}" class="card flex items-center justify-between hover:shadow-elevated transition-shadow">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8.5-8 9-4.5-.5-8-4-8-9V6l8-3z" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="font-medium">Privacy & Consent</span>
            </div>
            <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>

        <a href="{{ route('settings.accessibility') }}" class="card flex items-center justify-between hover:shadow-elevated transition-shadow">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3.5 3 14 0 18M12 3c-3 3.5-3 14 0 18" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="font-medium">Accessibility</span>
            </div>
            <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>

        <a href="{{ route('settings.data-management') }}" class="card flex items-center justify-between hover:shadow-elevated transition-shadow">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 3v6h6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="font-medium">Data Management</span>
            </div>
            <span class="badge-pending">Backup · Restore · Delete</span>
        </a>
    </div>

    <div class="mt-8 pt-6 border-t border-marena-ink-10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline w-full text-marena-danger border-marena-danger/30 hover:bg-marena-danger/5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Log Out
            </button>
        </form>
    </div>
</div>
@endsection