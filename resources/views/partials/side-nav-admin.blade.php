@php $current = $current ?? ''; @endphp
<aside class="sidebar">
    <!-- Logo -->
    <div class="flex items-center gap-2 px-3 mb-6">
        <img src="/marena-mark.svg" alt="" class="w-8 h-8">
        <span class="text-lg font-semibold text-white">MARÉNA Care</span>
    </div>

    <!-- Nav items -->
    <nav class="flex-1 space-y-1">
        <a href="{{ route('dashboard') }}" class="sidebar-item {{ $current === 'dashboard' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5L12 3l9 6.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z"/><path d="M9 22V12h6v10"/></svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.pending-approvals') }}" class="sidebar-item {{ $current === 'approvals' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <span>Approvals</span>
        </a>
        <a href="{{ route('admin.users') }}" class="sidebar-item {{ $current === 'users' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Users</span>
        </a>
        <a href="{{ route('admin.service-catalogue') }}" class="sidebar-item {{ $current === 'services' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-9M14 17H5M17 7a2 2 0 0 0 2 2v6a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2"/></svg>
            <span>Services</span>
        </a>
        <a href="{{ route('admin.matching') }}" class="sidebar-item {{ $current === 'matching' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Matching</span>
        </a>
        <a href="{{ route('admin.complaints') }}" class="sidebar-item {{ $current === 'complaints' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4M12 17h.01"/></svg>
            <span>Complaints</span>
        </a>
        <a href="{{ route('admin.messaging') }}" class="sidebar-item {{ $current === 'messages' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span>Messages</span>
        </a>
        <a href="{{ route('admin.analytics') }}" class="sidebar-item {{ $current === 'analytics' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-3"/></svg>
            <span>Analytics</span>
        </a>
        <a href="{{ route('admin.compliance') }}" class="sidebar-item {{ $current === 'compliance' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span>Compliance</span>
        </a>
        <a href="{{ route('settings') }}" class="sidebar-item {{ $current === 'settings' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            <span>Settings</span>
        </a>
    </nav>

    <!-- Bottom: User -->
    <div class="mt-auto pt-4 border-t border-marena-teal/40">
        <div class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-marena-sage-light">
            <div class="w-8 h-8 rounded-full bg-marena-teal text-white flex items-center justify-center text-xs font-semibold">
                {{ auth()->check() ? strtoupper(auth()->user()->name[0] ?? 'A') : 'A' }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white font-medium text-sm truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-marena-sage-light truncate">Administrator</p>
            </div>
        </div>
    </div>
</aside>