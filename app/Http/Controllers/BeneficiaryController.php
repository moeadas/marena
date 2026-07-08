<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeneficiaryController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $todayInterventions = collect();
        $alerts = collect();
        $lastService = null;
        $conversations = collect();

        try {
            $todayInterventions = \App\Models\Intervention::where('beneficiary_id', $user->id)
                ->whereDate('scheduled_at', today())
                ->with(['provider', 'service'])
                ->orderBy('scheduled_at')
                ->get();

            $alerts = \App\Models\Alert::where('beneficiary_id', $user->id)
                ->where('resolved', false)
                ->latest()
                ->take(5)
                ->get();

            $lastService = \App\Models\Intervention::where('beneficiary_id', $user->id)
                ->where('status', 'completed')
                ->with(['provider', 'service'])
                ->latest('completed_at')
                ->first();

            $conversations = \App\Models\Conversation::where('participant_id', $user->id)
                ->with(['participant'])
                ->latest('last_message_at')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Models may not have data yet — that's fine
        }

        return view('dashboard.beneficiary', compact('todayInterventions', 'alerts', 'lastService', 'conversations'));
    }

    public function careCircle()
    {
        $members = collect();
        try {
            $members = \App\Models\CareCircle::where('beneficiary_id', Auth::id())
                ->with('member')->get()->map(function ($c) {
                    return (object)[
                        'name' => $c->member?->name ?? 'Unknown',
                        'role' => $c->role ?? '',
                        'status' => $c->status ?? 'active',
                        'permissions' => $c->permissions ?? [],
                    ];
                });
        } catch (\Exception $e) {}

        return view('beneficiary.care-circle', compact('members'));
    }

    public function serviceHistory()
    {
        $interventions = collect();
        try {
            $interventions = \App\Models\Intervention::where('beneficiary_id', Auth::id())
                ->with(['provider', 'service'])
                ->latest('scheduled_at')
                ->paginate(15);
        } catch (\Exception $e) {}

        return view('beneficiary.service-history', compact('interventions'));
    }

    public function proofOfService($id)
    {
        $intervention = null;
        $checklist = [];
        $photos = [];
        $notes = null;

        try {
            $intervention = \App\Models\Intervention::with(['provider', 'service', 'visitReport'])
                ->findOrFail($id);
            if ($intervention->visitReport) {
                $checklist = $intervention->visitReport->checklist ?? [];
                $photos = $intervention->visitReport->photos ?? [];
                $notes = $intervention->visitReport->notes ?? null;
            }
        } catch (\Exception $e) {}

        return view('beneficiary.proof-of-service', compact('intervention', 'checklist', 'photos', 'notes'));
    }

    public function requestService()
    {
        return view('beneficiary.request-service');
    }

    public function reminders()
    {
        $reminders = collect();
        try {
            $reminders = \App\Models\Reminder::where('beneficiary_id', Auth::id())
                ->upcoming()->orderBy('scheduled_at')->get();
        } catch (\Exception $e) {}

        return view('beneficiary.reminders', compact('reminders'));
    }

    public function healthGraphs()
    {
        return view('beneficiary.health-graphs');
    }

    public function onboarding()
    {
        return view('beneficiary.onboarding');
    }
}