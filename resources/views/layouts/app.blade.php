<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2C5F5D">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="MARÉNA Care">
    <link rel="apple-touch-icon" href="/marena-mark.svg">
    <link rel="icon" type="image/svg+xml" href="/marena-mark.svg">

    <title>@yield('title', 'MARÉNA Care')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen">

    @php
        $isMobile = !empty($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']);
        $isAdmin = auth()->check() && auth()->user()->hasRole('admin');
        $showSidebar = $isAdmin && !$isMobile;
    @endphp

    <div class="min-h-screen flex flex-col bg-marena-cream">

        @if($showSidebar)
            @include('partials.side-nav-admin')
        @endif

        <!-- Top Bar -->
        @include('partials.top-bar')

        <!-- Main Content -->
        <main class="flex-1 {{ $showSidebar ? 'lg:ml-64' : '' }} pb-20 lg:pb-0 safe-top">
            <div class="max-w-4xl mx-auto px-4 py-4 sm:px-6 sm:py-6 lg:max-w-6xl lg:px-8">
                @yield('content')
            </div>
        </main>

        <!-- Bottom Navigation (mobile) -->
        @if(!$showSidebar)
            <nav class="bottom-nav lg:hidden">
                @yield('bottom_nav')
            </nav>
        @endif
    </div>

    @stack('scripts')

    <!-- PWA Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>
</body>
</html>