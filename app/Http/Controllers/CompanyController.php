<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function dashboard()
    {
        $employees = collect();
        $beneficiaries = collect();
        $stats = [
            'completion_rate' => '0%',
            'avg_rating' => '0.0',
            'active_visits' => 0,
            'missed_rate' => '0%',
        ];

        try {
            $employees = \App\Models\User::where('company_id', Auth::id())->get();
            $beneficiaries = \App\Models\Beneficiary::where('company_id', Auth::id())->get();
        } catch (\Exception $e) {}

        return view('dashboard.company', compact('employees', 'beneficiaries', 'stats'));
    }
}