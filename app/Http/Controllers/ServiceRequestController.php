<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role?->name;

        $query = ServiceRequest::with(['beneficiary.user', 'serviceCategory', 'matchedProvider.user']);

        if ($role === 'beneficiary') {
            $beneficiary = \App\Models\Beneficiary::where('user_id', $user->id)->first();
            $query->where('beneficiary_id', $beneficiary?->id);
        } elseif ($role === 'caregiver') {
            $beneficiaryIds = \App\Models\CareCircle::where('user_id', $user->id)
                ->where('member_type', 'caregiver')->pluck('beneficiary_id');
            $query->whereIn('beneficiary_id', $beneficiaryIds);
        }

        $requests = $query->latest()->paginate(20);
        return view('beneficiary.request-service', ['categories' => ServiceCategory::where('is_predefined', true)->orderBy('sort_order')->get(), 'requests' => $requests]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'service_category_id' => 'nullable|exists:service_categories,id',
            'urgency' => 'required|in:low,normal,high,urgent',
            'description' => 'nullable|string',
            'funding_preference' => 'nullable|in:any,state_funded,reimbursed,private,mixed,retirement_fund',
            'location' => 'nullable|string',
            'budget_max' => 'nullable|numeric',
        ]);

        $beneficiary = \App\Models\Beneficiary::where('user_id', Auth::id())->first();
        ServiceRequest::create(array_merge($validated, [
            'beneficiary_id' => $beneficiary->id,
            'requested_by' => Auth::id(),
            'status' => 'open',
        ]));

        return back()->with('success', 'Service request submitted.');
    }

    public function cancel(ServiceRequest $request)
    {
        $request->update(['status' => 'cancelled']);
        return back()->with('success', 'Request cancelled.');
    }
}