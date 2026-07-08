<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'language' => 'nullable|in:en,fr',
        ]);

        $user->update($validated);
        return back()->with('success', 'Settings updated successfully.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'language' => 'required|in:en,fr',
        ]);

        $user->update($validated);
        $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function password()
    {
        return view('settings.password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();
        return back()->with('success', 'Password updated successfully.');
    }

    public function notifications()
    {
        $user = Auth::user();
        $prefs = $user->notification_prefs ?? [];
        return view('settings.notifications', compact('user', 'prefs'));
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $user->notification_prefs = $request->only([
            'email_notifications', 'push_notifications', 'visit_reminders',
            'message_alerts', 'service_updates', 'weekly_summary'
        ]);
        $user->save();
        return back()->with('success', 'Notification preferences updated.');
    }

    public function privacy()
    {
        $user = Auth::user();
        return view('settings.privacy', compact('user'));
    }

    public function accessibility()
    {
        $user = Auth::user();
        $prefs = $user->accessibility_prefs ?? [];
        return view('settings.accessibility', compact('user', 'prefs'));
    }

    public function updateAccessibility(Request $request)
    {
        $user = Auth::user();
        $user->accessibility_prefs = $request->only([
            'large_text', 'high_contrast', 'reduced_motion', 'voice_assistance'
        ]);
        $user->save();
        return back()->with('success', 'Accessibility preferences updated.');
    }

    public function dataManagement()
    {
        $user = Auth::user();
        $isAdmin = $user->role?->name === 'admin';
        return view('settings.data-management', compact('user', 'isAdmin'));
    }
}