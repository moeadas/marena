@extends('layouts.app', ['pageTitle' => 'Import Data'])

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-marena-teal-deep">Import Data</h1>
    <p class="text-sm text-marena-ink-50">Restore your data from a backup file.</p>

    <form method="POST" action="{{ route('backup.import.store') }}" enctype="multipart/form-data" class="card space-y-4">
        @csrf
        <div>
            <label class="label">Backup File (JSON)</label>
            <input type="file" name="backup_file" accept=".json" class="w-full h-12 rounded-lg border border-marena-ink-30 bg-white px-4 text-marena-ink" required>
        </div>
        <button type="submit" class="btn-primary w-full">Import Data</button>
    </form>
</div>
@endsection