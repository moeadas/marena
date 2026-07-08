@extends('layouts.app', ['pageTitle' => 'Users'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'users'])
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-marena-teal-deep">Users</h1>
        <input type="text" class="input max-w-xs" placeholder="Search users...">
    </div>

    @if(isset($users) && $users->count() > 0)
        <div class="space-y-3">
            @foreach($users as $user)
                <div class="card flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-marena-sage-mist flex items-center justify-center text-sm font-semibold text-marena-teal-deep flex-shrink-0">
                        {{ strtoupper($user->name[0] ?? '?') }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-marena-ink truncate">{{ $user->name ?? 'User' }}</p>
                        <p class="text-xs text-marena-ink-50">{{ $user->email ?? '' }} &middot; {{ $user->role?->name ?? 'No role' }}</p>
                    </div>
                    <x-status-badge :status="$user->status ?? 'active'" />
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2;circle cx=9 cy=7 r=4" title="No users found" />
        </div>
    @endif
</div>
@endsection