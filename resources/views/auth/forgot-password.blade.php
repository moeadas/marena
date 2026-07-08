<x-layouts.guest>
    <div class="space-y-6">
        <div class="text-center">
            <div class="w-16 h-16 rounded-full bg-marena-sage-mist flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
            </div>
            <h1 class="text-2xl font-semibold text-marena-teal-deep">Reset password</h1>
            <p class="text-sm text-marena-ink-50 mt-2">Enter your email and we'll send you a reset link</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label class="label" for="email">Email address</label>
                <input id="email" type="email" name="email" class="input" placeholder="jane@example.com" required autofocus>
            </div>
            <button type="submit" class="btn-primary w-full">Send reset link</button>
        </form>

        <p class="text-center text-sm text-marena-ink-50">
            Remember your password? <a href="{{ route('login') }}" class="text-marena-teal font-medium">Sign in</a>
        </p>
    </div>
</x-layouts.guest>