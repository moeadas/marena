<x-layouts.guest>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-marena-teal-deep">Verify Email</h1>
            <p class="text-sm text-marena-ink-50 mt-1">Thanks for signing up! Please verify your email address by clicking the link we sent you.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="card bg-marena-success/10 text-marena-success text-sm text-center">
                A new verification link has been sent to your email.
            </div>
        @endif

        <div class="flex gap-2">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf
                <button type="submit" class="btn-primary w-full">Resend Verification Email</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-outline">Log Out</button>
            </form>
        </div>
    </div>
</x-layouts.guest>