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
            $timeline = \App\Models\Intervention::where('caregiver_id', $user->id)
                ->with(['beneficiary', 'service'])->latest()->take(5)->get();

            $alerts = \App\Models\Alert::where('caregiver_id', $user->id)
                ->where('resolved', false)->latest()->take(5)->get();

            $todaySchedule = \App\Models\Intervention::where('caregiver_id', $user->id)
                ->whereDate('scheduled_at', today())
                ->with(['beneficiary', 'service'])->orderBy('scheduled_at')->get();

            $careCircle = \App\Models\CareCircle::where('caregiver_id', $user->id)
                ->with('member')->take(4)->get()->map(function ($c) {
                    return (object)[
                        'name' => $c->member?->name ?? 'Member',
                        'role' => $c->role ?? '',
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
            $events = \App\Models\Intervention::where('caregiver_id', Auth::id())
                ->with(['beneficiary', 'service'])->latest()->paginate(20);
        } catch (\Exception $e) {}

        return view('caregiver.timeline', compact('events'));
    }

    public function alertsCenter()
    {
        $alerts = collect();
        try {
            $alerts = \App\Models\Alert::where('caregiver_id', Auth::id())
                ->where('resolved', false)->latest()->get();
        } catch (\Exception $e) {}

        return view('caregiver.alerts-center', compact('alerts'));
    }

    public function providersOverview()
    {
        $providers = collect();
        try {
            $providers = \App\Models\Provider::whereHas('careCircle', function ($q) {
                $q->where('caregiver_id', Auth::id());
            })->get();
        } catch (\Exception $e) {}

        return view('caregiver.providers-overview', compact('providers'));
    }

    public function coordinationActions()
    {
        return view('caregiver.coordination-actions');
    }
}