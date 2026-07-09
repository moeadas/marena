@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-marena-teal-deep mb-6">Password</h1>
    @if(session('success'))
    <div class="card mb-4 bg-marena-success/10 text-marena-success text-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="card mb-4 bg-marena-danger/10 text-marena-danger text-sm">{{ implode(' ', $errors->all()) }}</div>
    @endif
    <form method="POST" action="{{ route('settings.password.update') }}">
        @csrf
        <div class="card mb-4 space-y-4">
            <div>
                <label class="label">Current Password</label>
                <input type="password" name="current_password" class="input" required>
            </div>
            <div>
                <label class="label">New Password</label>
                <input type="password" name="password" class="input" required>
            </div>
            <div>
                <label class="label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="input" required>
            </div>
        </div>
        <button type="submit" class="btn-primary w-full">Update Password</button>
    </form>
</div>
@endsection