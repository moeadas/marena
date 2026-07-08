<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $kpis = [
            'total_users' => 0,
            'new_users' => 0,
            'active_interventions' => 0,
            'today_interventions' => 0,
            'pending_approvals' => 0,
            'open_complaints' => 0,
            'critical_complaints' => 0,
        ];

        $pendingApprovals = collect();
        $complaints = collect();

        try {
            $kpis['total_users'] = \App\Models\User::count();
            $kpis['active_interventions'] = \App\Models\Intervention::where('status', 'scheduled')->count();
            $kpis['pending_approvals'] = \App\Models\User::where('status', 'pending')->count();
            $kpis['open_complaints'] = \App\Models\Complaint::where('status', '!=', 'resolved')->count();

            $pendingApprovals = \App\Models\User::where('status', 'pending')->latest()->take(5)->get();
            $complaints = \App\Models\Complaint::latest()->take(3)->get();
        } catch (\Exception $e) {}

        return view('dashboard.admin', compact('kpis', 'pendingApprovals', 'complaints'));
    }

    public function pendingApprovals()
    {
        $approvals = collect();
        $counts = ['providers' => 0, 'companies' => 0, 'beneficiaries' => 0, 'caregivers' => 0];

        try {
            $approvals = \App\Models\User::where('status', 'pending')->latest()->get();
        } catch (\Exception $e) {}

        return view('admin.pending-approvals', compact('approvals', 'counts'));
    }

    public function providerVerification($id)
    {
        $provider = (object)['name' => 'Provider', 'title' => 'Nurse', 'company' => 'Independent'];

        try {
            $provider = \App\Models\User::findOrFail($id);
        } catch (\Exception $e) {}

        return view('admin.provider-verification', compact('provider'));
    }

    public function serviceCatalogueMgmt()
    {
        $services = collect();
        try {
            $services = \App\Models\ServiceCategory::with('services')->get();
        } catch (\Exception $e) {}

        return view('admin.service-catalogue-mgmt', compact('services'));
    }

    public function matchingRequests()
    {
        $requests = collect();
        try {
            $requests = \App\Models\ServiceRequest::where('status', 'open')
                ->with('beneficiary')->latest()->get();
        } catch (\Exception $e) {}

        return view('admin.matching-requests', compact('requests'));
    }

    public function complaints()
    {
        $complaints = collect();
        try {
            $complaints = \App\Models\Complaint::latest()->paginate(20);
        } catch (\Exception $e) {}

        return view('admin.complaints', compact('complaints'));
    }

    public function messagingOversight()
    {
        $broadcasts = collect();
        $tickets = collect();
        try {
            $broadcasts = \App\Models\Message::where('type', 'broadcast')->latest()->take(5)->get();
            $tickets = \App\Models\Message::where('type', 'ticket')->latest()->take(5)->get();
        } catch (\Exception $e) {}

        return view('admin.messaging-oversight', compact('broadcasts', 'tickets'));
    }

    public function analytics()
    {
        $stats = [
            'total_services' => 0,
            'completion_rate' => '0%',
            'avg_rating' => '0.0',
            'missed_rate' => '0%',
        ];

        try {
            $stats['total_services'] = \App\Models\Intervention::count();
            $completed = \App\Models\Intervention::where('status', 'completed')->count();
            $total = \App\Models\Intervention::count();
            $stats['completion_rate'] = $total > 0 ? round(($completed / $total) * 100) . '%' : '0%';
        } catch (\Exception $e) {}

        return view('admin.analytics', compact('stats'));
    }

    public function compliance()
    {
        $consentLogs = collect();
        $auditTrail = collect();
        $flaggedAccounts = collect();
        $retention = ['active' => 0, 'expiring' => 0, 'overdue' => 0];

        try {
            $consentLogs = \App\Models\ConsentLog::latest()->take(20)->get();
            $auditTrail = \App\Models\AuditLog::latest()->take(20)->get();
            $flaggedAccounts = \App\Models\User::where('flagged', true)->get();
        } catch (\Exception $e) {}

        return view('admin.compliance', compact('consentLogs', 'auditTrail', 'flaggedAccounts', 'retention'));
    }

    public function users()
    {
        $users = collect();
        try {
            $users = \App\Models\User::with('role')->latest()->paginate(20);
        } catch (\Exception $e) {}

        return view('admin.users', compact('users'));
    }
}