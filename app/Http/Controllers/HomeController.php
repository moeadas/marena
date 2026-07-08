<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $role = $user->role?->name ?? 'beneficiary';

        return match ($role) {
            'admin' => app(AdminController::class)->dashboard(),
            'provider' => app(ProviderController::class)->dashboard(),
            'caregiver' => app(CaregiverController::class)->dashboard(),
            'company' => app(CompanyController::class)->dashboard(),
            'employee' => app(EmployeeController::class)->dashboard(),
            default => app(BeneficiaryController::class)->dashboard(),
        };
    }
}