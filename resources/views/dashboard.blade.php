@extends('layouts.app', ['pageTitle' => 'Redirecting'])

@section('content')
<div class="space-y-6">
    <div class="card text-center">
        <p class="text-sm text-marena-ink-50">Loading your dashboard...</p>
    </div>
</div>

@section('scripts')
<script>
    window.location.replace('{{ route("dashboard") }}');
</script>
@endsection