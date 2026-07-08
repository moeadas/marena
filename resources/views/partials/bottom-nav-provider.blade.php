@php $current = $current ?? ''; @endphp
<a href="{{ route('dashboard') }}" class="bottom-nav-item {{ $current === 'dashboard' ? 'active' : '' }}">
    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z"/><path d="M9 22V12h6v10"/></svg>
    <span>Dashboard</span>
</a>
<a href="{{ route('provider.calendar') }}" class="bottom-nav-item {{ $current === 'calendar' ? 'active' : '' }}">
    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
    <span>Calendar</span>
</a>
<a href="{{ route('provider.beneficiaries') }}" class="bottom-nav-item {{ $current === 'beneficiaries' ? 'active' : '' }}">
    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
    <span>Beneficiaries</span>
</a>
<a href="{{ route('messages.index') }}" class="bottom-nav-item {{ $current === 'messages' ? 'active' : '' }}">
    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
    <span>Messages</span>
</a>
<a href="{{ route('settings') }}" class="bottom-nav-item {{ $current === 'profile' ? 'active' : '' }}">
    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    <span>Profile</span>
</a>