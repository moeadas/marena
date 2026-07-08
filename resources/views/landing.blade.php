<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MARÉNA Care — Care coordination made human</title>
    <meta name="description" content="One place to coordinate care, services, and daily support for the people who matter most.">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2C5F5D">
    <link rel="icon" href="/marena-mark.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/marena-mark.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            background: #F2EADD; color: #1F2D2C;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .hero {
            flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 2rem; text-align: center; max-width: 600px; margin: 0 auto;
        }
        .hero img { width: 180px; height: 180px; margin-bottom: 1.5rem; }
        .hero h1 { font-size: 2rem; color: #2C5F5D; margin-bottom: 0.75rem; font-weight: 600; }
        .hero p { font-size: 1.1rem; color: #3E7A78; margin-bottom: 2rem; line-height: 1.6; }
        .hero .tagline { font-size: 0.9rem; color: #6B807E; margin-bottom: 2rem; }
        .cta-group { display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.875rem 2rem; border-radius: 9999px; font-weight: 600;
            font-size: 1rem; transition: all 0.2s; text-decoration: none; border: none; cursor: pointer;
        }
        .btn-primary { background: #2C5F5D; color: #FAF5EB; }
        .btn-primary:hover { background: #1F4745; }
        .btn-secondary { background: transparent; color: #2C5F5D; border: 2px solid #2C5F5D; }
        .btn-secondary:hover { background: #D4E3DC; }
        .features { display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; margin-top: 3rem; }
        .feature { background: #FAF5EB; padding: 1.5rem; border-radius: 1rem; width: 200px; text-align: center; }
        .feature svg { color: #2C5F5D; margin-bottom: 0.5rem; }
        .feature h3 { font-size: 0.95rem; color: #2C5F5D; margin-bottom: 0.25rem; }
        .feature p { font-size: 0.85rem; color: #6B807E; }
        footer { padding: 1.5rem; text-align: center; color: #6B807E; font-size: 0.85rem; }
        @media (max-width: 640px) {
            .hero h1 { font-size: 1.5rem; }
            .hero p { font-size: 1rem; }
            .feature { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="hero">
        <img src="/marena-logo.svg" alt="MARÉNA Care">
        <h1>MARÉNA Care</h1>
        <p>One place to coordinate care, services, and daily support for the people who matter most.</p>
        <p class="tagline">Care coordination made human</p>
        <div class="cta-group">
            @guest
            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
            <a href="{{ route('login') }}" class="btn btn-secondary">Log In</a>
            @else
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            @endguest
        </div>
        <div class="features">
            <div class="feature">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2 20c1-3 3.5-4.5 7-4.5s6 1.5 7 4.5"/><circle cx="17" cy="9" r="2.5"/><path d="M22 18c-.5-2-2-3-4-3"/></svg>
                <h3>Care Circle</h3>
                <p>All stakeholders connected around one person</p>
            </div>
            <div class="feature">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l8 3v6c0 5-3.5 8.5-8 9-4.5-.5-8-4-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
                <h3>Proof of Service</h3>
                <p>Every visit tracked with checklists and reports</p>
            </div>
            <div class="feature">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                <h3>Health Tracking</h3>
                <p>Automatic graphs and trends over time</p>
            </div>
        </div>
    </div>
    <footer>© {{ date('Y') }} MARÉNA — Services &amp; Formation</footer>
</body>
</html>