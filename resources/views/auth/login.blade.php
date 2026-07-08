<x-layouts.guest>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-marena-teal-deep">Welcome back</h1>
            <p class="text-sm text-marena-ink-50 mt-1">Sign in to your MARÉNA Care account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="label" for="email">Email address</label>
                <input id="email" type="email" name="email" class="input" placeholder="jane@example.com" required autofocus>
            </div>

            <div>
                <label class="label" for="password">Password</label>
                <input id="password" type="password" name="password" class="input" placeholder="••••••••" required>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-marena-ink-30 text-marena-teal focus:ring-marena-teal">
                    <span class="text-sm text-marena-ink-50">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-marena-teal">Forgot password?</a>
            </div>

            <button type="submit" class="btn-primary w-full">Sign in</button>
        </form>

        <p class="text-center text-sm text-marena-ink-50">
            Don't have an account? <a href="{{ route('register') }}" class="text-marena-teal font-medium">Sign up</a>
        </p>
    </div>
</x-layouts.guest>