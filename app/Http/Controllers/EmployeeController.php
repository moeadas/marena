<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $visits = collect();
        try {
            $visits = \App\Models\Intervention::where('employee_id', Auth::id())
                ->whereDate('scheduled_at', today())
                ->with(['beneficiary', 'service'])
                ->orderBy('scheduled_at')->get();
        } catch (\Exception $e) {}

        return view('dashboard.employee', compact('visits'));
    }
}