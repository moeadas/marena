<x-layouts.guest>
    <div class="space-y-6">
        <div class="text-center">
            <div class="w-16 h-16 rounded-full bg-marena-sage-mist flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h1 class="text-2xl font-semibold text-marena-teal-deep">New password</h1>
            <p class="text-sm text-marena-ink-50 mt-2">Create a new password for your account</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token ?? '' }}">

            <div>
                <label class="label" for="email">Email address</label>
                <input id="email" type="email" name="email" class="input" placeholder="jane@example.com" required autofocus>
            </div>

            <div>
                <label class="label" for="password">New password</label>
                <input id="password" type="password" name="password" class="input" placeholder="••••••••" required>
            </div>

            <div>
                <label class="label" for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-primary w-full">Reset password</button>
        </form>
    </div>
</x-layouts.guest>