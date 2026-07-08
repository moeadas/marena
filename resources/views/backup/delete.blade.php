@extends('layouts.app', ['pageTitle' => 'Delete Account'])

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-danger">Delete Account</h1>
    <p class="text-sm text-marena-ink-50">This action is permanent and cannot be undone.</p>

    <div class="card bg-marena-danger/5 border border-marena-danger/20">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-marena-danger flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4M12 17h.01"/></svg>
            <div>
                <p class="text-sm font-medium text-marena-danger">Warning</p>
                <p class="text-xs text-marena-ink-50 mt-1">All your data, including interventions, messages, and health records, will be permanently deleted.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('backup.destroy') }}" class="card space-y-4">
        @csrf
        @method('DELETE')
        <label class="flex items-start gap-2">
            <input type="checkbox" name="confirm" value="1" class="mt-1 rounded text-marena-danger" required>
            <span class="text-sm text-marena-ink-70">I understand this action is irreversible and all my data will be lost.</span>
        </label>
        <button type="submit" class="btn-danger w-full">Permanently Delete My Account</button>
    </form>

    <a href="{{ route('settings') }}" class="btn-outline w-full">← Back to Settings</a>
</div>
@endsection