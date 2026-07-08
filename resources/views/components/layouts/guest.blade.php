@props(['title' => 'MARÉNA Care'])

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

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen bg-marena-cream flex flex-col items-center justify-center px-4 safe-top">

    <!-- Logo -->
    <div class="mb-8">
        <img src="/marena-logo.svg" alt="MARÉNA Care" class="h-12 w-auto">
    </div>

    <!-- Card -->
    <div class="w-full max-w-md">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-sm text-marena-ink-50">
        <p>MARÉNA Care &middot; Care coordination, simplified</p>
    </div>

    @stack('scripts')
</body>
</html>