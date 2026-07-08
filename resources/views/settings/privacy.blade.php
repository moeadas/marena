@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-marena-teal-deep mb-6">Privacy & Consent</h1>
    <div class="card mb-4">
        <h2 class="font-semibold text-marena-teal-deep mb-2">Your Privacy</h2>
        <p class="text-sm text-marena-ink-50 mb-3">MARÉNA Care is designed with privacy by design. Your data is encrypted, access-controlled, and never shared without consent.</p>
    </div>
    <div class="card mb-4">
        <h3 class="font-medium mb-2">Consent History</h3>
        @php $logs = \App\Models\ConsentLog::where('user_id', $user->id)->latest()->get(); @endphp
        @foreach($logs as $log)
        <div class="flex items-center justify-between py-2 border-b border-marena-ink-10 last:border-0">
            <div>
                <p class="text-sm font-medium">{{ $log->description }}</p>
                <p class="text-xs text-marena-ink-50">{{ $log->created_at->format('M j, Y') }} · v{{ $log->version }}</p>
            </div>
            <span class="badge-completed">✓ Accepted</span>
        </div>
        @endforeach
    </div>
    <div class="card">
        <h3 class="font-medium mb-2">Data Rights</h3>
        <p class="text-sm text-marena-ink-50 mb-2">You have the right to:</p>
        <ul class="text-sm text-marena-ink-50 space-y-1 list-disc pl-5">
            <li>Access your data</li>
            <li>Export your data (use Data Management → Backup)</li>
            <li>Delete your data (contact admin)</li>
            <li>Withdraw consent at any time</li>
        </ul>
    </div>
</div>
@endsection