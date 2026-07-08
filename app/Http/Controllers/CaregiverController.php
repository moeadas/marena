<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaregiverController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $timeline = collect();
        $alerts = collect();
        $todaySchedule = collect();
        $pendingTasks = collect();
        $careCircle = collect();

        try {
            // Find beneficiary_ids for this caregiver via care_circles
            $beneficiaryIds = \App\Models\CareCircle::where('user_id', $user->id)
                ->where('member_type', 'caregiver')
                ->where('status', 'active')
                ->pluck('beneficiary_id');

            $timeline = \App\Models\Intervention::whereIn('beneficiary_id', $beneficiaryIds)
                ->with(['beneficiary', 'service'])->latest()->take(5)->get();

            $alerts = \App\Models\Alert::where('target_user_id', $user->id)
                ->where('is_read', false)->latest()->take(5)->get();

            $todaySchedule = \App\Models\Intervention::whereIn('beneficiary_id', $beneficiaryIds)
                ->whereDate('scheduled_at', today())
                ->with(['beneficiary', 'service'])->orderBy('scheduled_at')->get();

            $careCircle = \App\Models\CareCircle::where('user_id', $user->id)
                ->with('beneficiary')->take(4)->get()->map(function ($c) {
                    return (object)[
                        'name' => $c->beneficiary?->user?->name ?? 'Member',
                        'role' => $c->member_type ?? '',
                        'status' => $c->status ?? 'active',
                    ];
                });
        } catch (\Exception $e) {}

        return view('dashboard.caregiver', compact('timeline', 'alerts', 'todaySchedule', 'pendingTasks', 'careCircle'));
    }

    public function timeline()
    {
        $events = collect();
        try {
            $beneficiaryIds = \App\Models\CareCircle::where('user_id', Auth::id())
                ->where('member_type', 'caregiver')
                ->where('status', 'active')
                ->pluck('beneficiary_id');

            $events = \App\Models\Intervention::whereIn('beneficiary_id', $beneficiaryIds)
                ->with(['beneficiary', 'service'])->latest()->paginate(20);
        } catch (\Exception $e) {}

        return view('caregiver.timeline', compact('events'));
    }

    public function alertsCenter()
    {
        $alerts = collect();
        try {
            $alerts = \App\Models\Alert::where('target_user_id', Auth::id())
                ->where('is_read', false)->latest()->get();
        } catch (\Exception $e) {}

        return view('caregiver.alerts-center', compact('alerts'));
    }

    public function providersOverview()
    {
        $providers = collect();
        try {
            $beneficiaryIds = \App\Models\CareCircle::where('user_id', Auth::id())
                ->where('member_type', 'caregiver')
                ->where('status', 'active')
                ->pluck('beneficiary_id');

            $providerIds = \App\Models\CareCircle::whereIn('beneficiary_id', $beneficiaryIds)
                ->where('member_type', 'provider')
                ->pluck('user_id');

            $providers = \App\Models\Provider::whereIn('user_id', $providerIds)->with('user')->get();
        } catch (\Exception $e) {}

        return view('caregiver.providers-overview', compact('providers'));
    }

    public function coordinationActions()
    {
        return view('caregiver.coordination-actions');
    }
}