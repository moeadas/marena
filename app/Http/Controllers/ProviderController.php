<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $todaySchedule = collect();
        $notifications = collect();

        try {
            $todaySchedule = \App\Models\Intervention::where('provider_id', $user->id)
                ->whereDate('scheduled_at', today())
                ->with(['beneficiary', 'service'])
                ->orderBy('scheduled_at')->get();

            $notifications = \App\Models\Alert::where('provider_id', $user->id)
                ->latest()->take(5)->get();
        } catch (\Exception $e) {}

        return view('dashboard.provider', compact('todaySchedule', 'notifications'));
    }

    public function calendar()
    {
        return view('provider.calendar');
    }

    public function beneficiaries()
    {
        $beneficiaries = collect();
        try {
            $beneficiaries = \App\Models\Beneficiary::whereHas('interventions', function ($q) {
                $q->where('provider_id', Auth::id());
            })->get();
        } catch (\Exception $e) {}

        return view('provider.beneficiaries', compact('beneficiaries'));
    }

    public function visitExecution($id = null)
    {
        return view('provider.visit-execution');
    }

    public function proofSubmission()
    {
        return view('provider.proof-submission');
    }

    public function serviceCatalogue()
    {
        $services = collect();
        try {
            $services = \App\Models\Service::where('provider_id', Auth::id())
                ->orWhereNull('provider_id')->get();
        } catch (\Exception $e) {}

        return view('provider.service-catalogue', compact('services'));
    }

    public function reviews()
    {
        $reviews = collect();
        try {
            $reviews = \App\Models\ProviderReview::where('provider_id', Auth::id())
                ->latest()->get();
        } catch (\Exception $e) {}

        return view('provider.reviews', compact('reviews'));
    }

    public function companyManagement()
    {
        $employees = collect();
        $beneficiaries = collect();
        $stats = ['completion' => '95%', 'on_time' => '88%', 'satisfaction' => '4.7'];

        try {
            $employees = \App\Models\User::where('company_id', Auth::id())
                ->where('role_id', '!=', null)->get();
        } catch (\Exception $e) {}

        return view('provider.company-management', compact('employees', 'beneficiaries', 'stats'));
    }

    public function employeeProfile($id)
    {
        $employee = (object)['name' => 'Employee', 'role' => 'Nurse', 'status' => 'active'];
        $beneficiaries = collect();

        try {
            $employee = \App\Models\User::findOrFail($id);
        } catch (\Exception $e) {}

        return view('provider.employee-profile', compact('employee', 'beneficiaries'));
    }

    public function onboarding()
    {
        return view('provider.onboarding');
    }
}