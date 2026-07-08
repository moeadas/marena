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
            $ben = \App\Models\Beneficiary::where('user_id', $user->id)->first();
            $benId = $ben?->id ?? 0;

            $todayInterventions = \App\Models\Intervention::where('beneficiary_id', $benId)
                ->whereDate('scheduled_at', today())
                ->with(['provider', 'service'])
                ->orderBy('scheduled_at')
                ->get();

            $alerts = \App\Models\Alert::where('beneficiary_id', $benId)
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->get();

            $lastService = \App\Models\Intervention::where('beneficiary_id', $benId)
                ->where('status', 'completed')
                ->with(['provider', 'service'])
                ->latest('completed_at')
                ->first();
        } catch (\Exception $e) {}

        return view('dashboard.beneficiary', compact('todayInterventions', 'alerts', 'lastService', 'conversations'));
    }

    public function careCircle()
    {
        $members = collect();
        try {
            $ben = \App\Models\Beneficiary::where('user_id', Auth::id())->first();
            $benId = $ben?->id ?? 0;

            $members = \App\Models\CareCircle::where('beneficiary_id', $benId)
                ->with(['user', 'beneficiary'])->get()->map(function ($c) {
                    return (object)[
                        'name' => $c->user?->name ?? 'Unknown',
                        'role' => $c->member_type ?? '',
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
            $ben = \App\Models\Beneficiary::where('user_id', Auth::id())->first();
            $interventions = \App\Models\Intervention::where('beneficiary_id', $ben?->id ?? 0)
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
            $ben = \App\Models\Beneficiary::where('user_id', Auth::id())->first();
            $reminders = \App\Models\Reminder::where('beneficiary_id', $ben?->id ?? 0)
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