<x-layouts.guest>
    <div class="space-y-6" x-data="{ code: ['', '', '', '', '', ''] }">
        <div class="text-center">
            <div class="w-16 h-16 rounded-full bg-marena-sage-mist flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-marena-teal" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h1 class="text-2xl font-semibold text-marena-teal-deep">Verify your number</h1>
            <p class="text-sm text-marena-ink-50 mt-2">Enter the 6-digit code sent to your phone</p>
        </div>

        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
            @csrf

            <!-- OTP Inputs -->
            <div class="flex justify-center gap-2 sm:gap-3">
                @for($i = 0; $i < 6; $i++)
                    <input
                        type="text"
                        maxlength="1"
                        inputmode="numeric"
                        x-model="code[{{ $i }}]"
                        x-data
                        x-init="$watch('code[{{ $i }}]', val => { if(val.length === 1 && {{ $i }} < 5) $nextTick(() => $refs.otp{{ $i + 1 }}.focus()) })"
                        x-ref="otp{{ $i }}"
                        name="otp[]"
                        class="w-12 h-14 text-center text-xl font-semibold rounded-lg border border-marena-ink-30 bg-white text-marena-ink focus:border-marena-teal focus:ring-2 focus:ring-marena-teal/20 transition-colors"
                        required
                    >
                @endfor
            </div>

            <button type="submit" class="btn-primary w-full">Verify code</button>

            <div class="text-center">
                <p class="text-sm text-marena-ink-50">Didn't receive a code?</p>
                <button type="button" class="text-sm text-marena-teal font-medium mt-1" x-data="{ sent: false, timer: 0 }" @click="sent = true; timer = 30; let interval = setInterval(() => { timer--; if(timer <= 0) clearInterval(interval) }, 1000)">
                    <span x-show="!sent">Resend code</span>
                    <span x-show="sent" x-text="timer > 0 ? `Resend in ${timer}s` : 'Resend code'" @click="if(timer <= 0) sent = false"></span>
                </button>
            </div>
        </form>
    </div>
</x-layouts.guest>