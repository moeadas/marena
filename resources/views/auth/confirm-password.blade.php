<x-layouts.guest>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-marena-teal-deep">Confirm Password</h1>
            <p class="text-sm text-marena-ink-50 mt-1">This is a secure area. Please confirm your password before continuing.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <div>
                <label class="label" for="password">Password</label>
                <input id="password" type="password" name="password" class="input" required autocomplete="current-password" autofocus>
            </div>

            @if($errors->any())
                <div class="card bg-marena-danger/10 text-marena-danger text-sm">{{ implode(' ', $errors->all()) }}</div>
            @endif

            <button type="submit" class="btn-primary w-full">Confirm</button>
        </form>
    </div>
</x-layouts.guest>