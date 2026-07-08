@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-marena-teal-deep mb-6">Data Management</h1>

    {{-- Backup Section --}}
    <div class="card mb-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-marena-sage-mist flex items-center justify-center">
                <svg class="w-5 h-5 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <h2 class="font-semibold text-marena-teal-deep">Backup All Data</h2>
                <p class="text-sm text-marena-ink-50">Export everything as a JSON file</p>
            </div>
        </div>
        <p class="text-sm text-marena-ink-50 mb-3">Download a complete backup of all data including users, interventions, reports, messages, and more. Keep this file safe — you can restore from it anytime.</p>
        <form method="POST" action="{{ route('backup.export') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Download Backup
            </button>
        </form>
    </div>

    {{-- Import Section --}}
    <div class="card mb-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-marena-sage-mist flex items-center justify-center">
                <svg class="w-5 h-5 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 15v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4M17 8l-5-5-5 5M12 3v12" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <h2 class="font-semibold text-marena-teal-deep">Import Data from Backup</h2>
                <p class="text-sm text-marena-ink-50">Restore from a previous backup</p>
            </div>
        </div>
        <p class="text-sm text-marena-ink-50 mb-3">⚠️ This will replace all current data with the contents of the backup file. Make sure you have a current backup before importing.</p>
        <form method="POST" action="{{ route('backup.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="backup_file" accept=".json" class="input mb-3" required>
            <button type="submit" class="btn btn-secondary w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 15v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4M17 8l-5-5-5 5M12 3v12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Import Backup File
            </button>
        </form>
    </div>

    {{-- Delete All Data Section (Admin only) --}}
    @if($isAdmin)
    <div class="card border-2 border-marena-danger/20 mb-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-marena-danger/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-marena-danger" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <h2 class="font-semibold text-marena-danger">Delete All Data</h2>
                <p class="text-sm text-marena-ink-50">Start fresh — removes everything</p>
            </div>
        </div>
        <p class="text-sm text-marena-ink-50 mb-3">⚠️ This permanently deletes ALL data (users, beneficiaries, providers, interventions, reports, messages, etc.) except your admin account. This cannot be undone. Make sure you have a backup first.</p>

        <div x-data="{ showConfirm: false }">
            <button @click="showConfirm = true" class="btn btn-danger w-full mb-3" x-show="!showConfirm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Delete All Data
            </button>

            <div x-show="showConfirm" x-transition class="space-y-3" style="display: none;">
                <p class="text-sm font-medium text-marena-danger text-center">Are you absolutely sure?</p>
                <p class="text-xs text-marena-ink-50 text-center">Type "DELETE" to confirm. This action is irreversible.</p>
                <form method="POST" action="{{ route('backup.delete-all') }}" onsubmit="return this.confirm.value === 'DELETE'">
                    @csrf
                    <input type="text" name="confirm" placeholder="Type DELETE" class="input mb-3 text-center font-bold" required>
                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-danger flex-1">Yes, Delete Everything</button>
                        <button type="button" @click="showConfirm = false" class="btn btn-outline">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="card mb-4 opacity-60">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <div>
                <h2 class="font-semibold text-marena-ink-50">Delete All Data</h2>
                <p class="text-xs text-marena-ink-30">Admin access required</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Recent Backups --}}
    <div class="mt-6">
        <h3 class="font-semibold text-marena-teal-deep mb-3">Recent Backups</h3>
        <div class="space-y-2">
            @php $backups = \App\Models\Backup::with('user')->latest()->limit(10)->get(); @endphp
            @forelse($backups as $backup)
            <div class="card-tight flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-marena-sage" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <div>
                        <p class="text-sm font-medium">{{ $backup->filename }}</p>
                        <p class="text-xs text-marena-ink-50">{{ $backup->created_at->format('M j, Y \a\t H:i') }} · {{ number_format($backup->file_size / 1024, 1) }} KB</p>
                    </div>
                </div>
                <span class="badge {{ $backup->type === 'import' ? 'badge-pending' : 'badge-completed' }}">{{ $backup->type }}</span>
            </div>
            @empty
            <p class="text-sm text-marena-ink-50 text-center py-4">No backups yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection