@extends('layouts.app', ['pageTitle' => 'Care Circle'])

@section('bottom_nav')
    @include('partials.bottom-nav-beneficiary', ['current' => 'circle'])
@endsection

@section('content')
<div class="space-y-6">
    <x-section-header title="My Care Circle" action-label="Add Member" action-route="#" />

    <p class="text-sm text-marena-ink-50 -mt-3">The people involved in your care journey.</p>

    <!-- Member cards -->
    @if(isset($members) && $members->count() > 0)
        <div class="space-y-3">
            @foreach($members as $member)
                <x-care-circle-member
                    :name="$member->name ?? 'Member'"
                    :role="$member->role ?? ''"
                    :status="$member->status ?? 'active'"
                    :permissions="$member->permissions ?? []"
                >
                    <button class="p-2 rounded-full hover:bg-marena-sage-mist" aria-label="Permissions">
                        <svg class="w-5 h-5 text-marena-ink-30" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </button>
                </x-care-circle-member>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state
                icon="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2;circle cx=9 cy=7 r=4"
                title="No care circle members"
                cta="Add a member"
                cta-route="#"
            >
                Your care circle includes caregivers, providers, and family members.
            </x-empty-state>
        </div>
    @endif

    <!-- Permissions info -->
    <div class="card bg-marena-sage-mist/50">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-marena-teal-soft flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
            <div>
                <p class="text-sm font-medium text-marena-teal-deep">Manage permissions</p>
                <p class="text-xs text-marena-ink-50 mt-1">Control what each member can see and do. Tap the shield icon next to any member to adjust their access.</p>
            </div>
        </div>
    </div>
</div>
@endsection