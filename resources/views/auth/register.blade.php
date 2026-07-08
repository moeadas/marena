<x-layouts.guest>
    <div class="space-y-6">
        <!-- Title -->
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-marena-teal-deep">Create your account</h1>
            <p class="text-sm text-marena-ink-50 mt-1">Join MARÉNA Care today</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ selectedRole: '', step: 1 }">
            @csrf

            <!-- Step 1: Role Selection -->
            <div x-show="step === 1" x-transition class="space-y-4">
                <div>
                    <label class="label text-center block">I am a...</label>
                    <div class="grid grid-cols-2 gap-3 mt-3">
                        @php
                            $roles = [
                                ['value' => 'beneficiary', 'label' => 'Beneficiary', 'icon' => 'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2;circle cx=12 cy=7 r=4'],
                                ['value' => 'caregiver', 'label' => 'Caregiver', 'icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2;circle cx=9 cy=7 r=4;M23 21v-2a4 4 0 0 0-3-3.87;M16 3.13a4 4 0 0 1 0 7.75'],
                                ['value' => 'provider', 'label' => 'Provider', 'icon' => 'M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4'],
                                ['value' => 'company', 'label' => 'Company', 'icon' => 'M3 21h18M3 7l9-4 9 4M5 21V7M19 21V7M9 21v-6h6v6'],
                                ['value' => 'employee', 'label' => 'Employee', 'icon' => 'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2;circle cx=12 cy=7 r=4'],
                                ['value' => 'admin', 'label' => 'Admin', 'icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z'],
                            ];
                        @endphp
                        @foreach($roles as $role)
                            <button type="button"
                                @click="selectedRole = '{{ $role['value'] }}'"
                                :class="selectedRole === '{{ $role['value'] }}' ? 'border-marena-teal bg-marena-sage-mist' : 'border-marena-ink-10 bg-white'"
                                class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 transition-all hover:border-marena-teal-soft">
                                <svg class="w-7 h-7 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                    @foreach(explode(';', $role['icon']) as $path)
                                        <path d="{{ $path }}"/>
                                    @endforeach
                                </svg>
                                <span class="text-sm font-medium text-marena-ink-70">{{ $role['label'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <button type="button" @click="step = 2" :disabled="!selectedRole"
                    :class="!selectedRole ? 'opacity-50 cursor-not-allowed' : ''"
                    class="btn-primary w-full">
                    Continue
                </button>
            </div>

            <!-- Step 2: Sign Up Form -->
            <div x-show="step === 2" x-transition class="space-y-4">
                <input type="hidden" name="role" x-model="selectedRole">

                <div>
                    <label class="label" for="name">Full name</label>
                    <input id="name" type="text" name="name" class="input" placeholder="Jane Doe" required autofocus>
                </div>

                <div>
                    <label class="label" for="email">Email address</label>
                    <input id="email" type="email" name="email" class="input" placeholder="jane@example.com" required>
                </div>

                <div>
                    <label class="label" for="password">Password</label>
                    <input id="password" type="password" name="password" class="input" placeholder="••••••••" required>
                </div>

                <div>
                    <label class="label" for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="input" placeholder="••••••••" required>
                </div>

                <div class="flex items-start gap-2">
                    <input type="checkbox" name="terms" id="terms" class="mt-1 rounded border-marena-ink-30 text-marena-teal focus:ring-marena-teal" required>
                    <label for="terms" class="text-sm text-marena-ink-50">I agree to the <a href="#" class="text-marena-teal underline">Terms</a> and <a href="#" class="text-marena-teal underline">Privacy Policy</a></label>
                </div>

                <button type="submit" class="btn-primary w-full">Create account</button>

                <button type="button" @click="step = 1" class="btn-ghost w-full">← Back</button>
            </div>

            <p class="text-center text-sm text-marena-ink-50">
                Already have an account? <a href="{{ route('login') }}" class="text-marena-teal font-medium">Sign in</a>
            </p>
        </form>
    </div>
</x-layouts.guest>