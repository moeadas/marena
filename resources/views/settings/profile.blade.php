@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-marena-teal-deep mb-6">Profile</h1>
    <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @if(session('success'))
        <div class="card mb-4 bg-marena-success/10 text-marena-success text-sm">{{ session('success') }}</div>
        @endif

        <div class="card mb-4 space-y-4">
            <div>
                <label class="label">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="input" required>
            </div>
            <div>
                <label class="label">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="input" required>
            </div>
            <div>
                <label class="label">Email</label>
                <input type="email" value="{{ $user->email }}" class="input opacity-60" disabled>
            </div>
            <div>
                <label class="label">Phone</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="input">
            </div>
            <div>
                <label class="label">Language</label>
                <select name="language" class="input">
                    <option value="en" @selected($user->language === 'en')>English</option>
                    <option value="fr" @selected($user->language === 'fr')>Français</option>
                </select>
            </div>
            <div>
                <label class="label">Avatar</label>
                <input type="file" name="avatar" accept="image/*" class="input">
            </div>
        </div>

        <button type="submit" class="btn-primary w-full">Save Changes</button>
    </form>
</div>
@endsection