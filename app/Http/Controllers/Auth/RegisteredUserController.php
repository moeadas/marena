<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Beneficiary;
use App\Models\Provider;
use App\Models\Company;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        $role = Role::find($request->role_id);
        $status = in_array($role->name, ['admin', 'beneficiary', 'caregiver']) ? 'active' : 'pending';

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => $status,
            'consent_data' => json_encode(['terms_accepted' => true, 'privacy_accepted' => true, 'date' => now()->toISOString()]),
        ]);

        // Generate OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Create role-specific records
        if ($role->name === 'beneficiary') {
            Beneficiary::create(['user_id' => $user->id]);
        } elseif ($role->name === 'provider') {
            Provider::create([
                'user_id' => $user->id,
                'is_independent' => true,
                'verification_status' => 'pending',
            ]);
        } elseif ($role->name === 'company_manager') {
            // Company will be created during onboarding
        }

        event(new Registered($user));
        Auth::login($user);

        // Redirect to OTP verification
        return redirect()->route('otp.verify')->with('status', "Verification code sent. (Demo: {$otpCode})");
    }
}