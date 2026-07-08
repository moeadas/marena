<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\VisitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterventionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role?->name;

        $query = Intervention::with(['provider.user', 'beneficiary.user', 'service']);

        if ($role === 'beneficiary') {
            $beneficiary = \App\Models\Beneficiary::where('user_id', $user->id)->first();
            $query->where('beneficiary_id', $beneficiary?->id);
        } elseif ($role === 'provider') {
            $provider = \App\Models\Provider::where('user_id', $user->id)->first();
            $query->where('provider_id', $provider?->id);
        } elseif ($role === 'caregiver') {
            $beneficiaryIds = \App\Models\CareCircle::where('user_id', $user->id)
                ->where('member_type', 'caregiver')->pluck('beneficiary_id');
            $query->whereIn('beneficiary_id', $beneficiaryIds);
        }

        $interventions = $query->orderByDesc('scheduled_at')->paginate(20);
        return view('beneficiary.service-history', compact('interventions'));
    }

    public function show(Intervention $intervention)
    {
        $intervention->load(['provider.user', 'beneficiary.user', 'service', 'visitReports']);
        return view('beneficiary.proof-of-service', compact('intervention'));
    }

    public function flagIssue(Request $request, Intervention $intervention)
    {
        $validated = $request->validate(['issue_description' => 'required|string']);
        $intervention->update([
            'has_issue' => true,
            'issue_description' => $validated['issue_description'],
        ]);
        return back()->with('success', 'Issue flagged. The care circle has been notified.');
    }

    public function cancel(Request $request, Intervention $intervention)
    {
        $validated = $request->validate(['cancel_reason' => 'required|string']);
        $intervention->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancel_reason' => $validated['cancel_reason'],
        ]);
        return back()->with('success', 'Intervention cancelled.');
    }
}