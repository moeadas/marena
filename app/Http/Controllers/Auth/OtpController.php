<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function show()
    {
        return view('auth.otp-verify');
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        if ($user->otp_code === $validated['code'] && $user->otp_expires_at && $user->otp_expires_at->isFuture()) {
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'phone_verified_at' => now(),
            ]);
            return redirect()->route('dashboard')->with('success', 'Phone number verified!');
        }

        return back()->withErrors(['code' => 'Invalid or expired code.']);
    }

    public function resend()
    {
        $user = Auth::user();
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'otp_code' => $code,
            'otp_expires_at' => now()->addMinutes(10),
        ]);
        // In production: send via SMS
        return back()->with('status', "Code sent. (Demo: {$code})");
    }
}