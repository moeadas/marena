<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
})->name('home');

// Auth routes (from Breeze + custom OTP)
require __DIR__ . '/auth.php';

// OTP routes
Route::middleware('guest')->group(function () {
    Route::view('/otp-verify', 'auth.otp-verify')->name('otp.verify');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('/settings/password', [SettingsController::class, 'password'])->name('settings.password');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::get('/settings/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::post('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::get('/settings/privacy', [SettingsController::class, 'privacy'])->name('settings.privacy');
    Route::get('/settings/accessibility', [SettingsController::class, 'accessibility'])->name('settings.accessibility');
    Route::post('/settings/accessibility', [SettingsController::class, 'updateAccessibility'])->name('settings.accessibility.update');
    Route::get('/settings/data-management', [SettingsController::class, 'dataManagement'])->name('settings.data-management');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}/send', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/messages/new', [MessageController::class, 'newConversation'])->name('messages.new');

    // Backup / Data Management
    Route::post('/backup/export', [BackupController::class, 'export'])->name('backup.export');
    Route::post('/backup/import', [BackupController::class, 'import'])->name('backup.import');
    Route::post('/backup/delete-all', [BackupController::class, 'destroy'])->name('backup.delete-all');

    // Interventions
    Route::get('/interventions', [InterventionController::class, 'index'])->name('interventions.index');
    Route::get('/interventions/{intervention}', [InterventionController::class, 'show'])->name('interventions.show');
    Route::post('/interventions/{intervention}/flag', [InterventionController::class, 'flagIssue'])->name('interventions.flag');
    Route::post('/interventions/{intervention}/cancel', [InterventionController::class, 'cancel'])->name('interventions.cancel');

    // Service Requests
    Route::get('/service-requests', [ServiceRequestController::class, 'index'])->name('service-requests.index');
    Route::post('/service-requests', [ServiceRequestController::class, 'store'])->name('service-requests.store');
    Route::post('/service-requests/{request}/cancel', [ServiceRequestController::class, 'cancel'])->name('service-requests.cancel');

    // Beneficiary routes
    Route::prefix('beneficiary')->name('beneficiary.')->group(function () {
        Route::get('/dashboard', [BeneficiaryController::class, 'dashboard'])->name('dashboard');
        Route::get('/care-circle', [BeneficiaryController::class, 'careCircle'])->name('care-circle');
        Route::get('/service-history', [BeneficiaryController::class, 'serviceHistory'])->name('service-history');
        Route::get('/proof-of-service/{id}', [BeneficiaryController::class, 'proofOfService'])->name('proof-of-service');
        Route::get('/request-service', [BeneficiaryController::class, 'requestService'])->name('request-service');
        Route::get('/reminders', [BeneficiaryController::class, 'reminders'])->name('reminders');
        Route::get('/health-graphs', [BeneficiaryController::class, 'healthGraphs'])->name('health-graphs');
        Route::get('/onboarding', [BeneficiaryController::class, 'onboarding'])->name('onboarding');
    });

    // Caregiver routes
    Route::prefix('caregiver')->name('caregiver.')->group(function () {
        Route::get('/dashboard', [CaregiverController::class, 'dashboard'])->name('dashboard');
        Route::get('/timeline', [CaregiverController::class, 'timeline'])->name('timeline');
        Route::get('/alerts', [CaregiverController::class, 'alertsCenter'])->name('alerts');
        Route::get('/providers', [CaregiverController::class, 'providersOverview'])->name('providers-overview');
        Route::get('/coordination', [CaregiverController::class, 'coordinationActions'])->name('coordination');
    });

    // Provider routes
    Route::prefix('provider')->name('provider.')->group(function () {
        Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');
        Route::get('/calendar', [ProviderController::class, 'calendar'])->name('calendar');
        Route::get('/beneficiaries', [ProviderController::class, 'beneficiaries'])->name('beneficiaries');
        Route::get('/visit/{id?}', [ProviderController::class, 'visitExecution'])->name('visit-execution');
        Route::get('/proof-submission/{id?}', [ProviderController::class, 'proofSubmission'])->name('proof-submission');
        Route::get('/service-catalogue', [ProviderController::class, 'serviceCatalogue'])->name('service-catalogue');
        Route::get('/reviews', [ProviderController::class, 'reviews'])->name('reviews');
        Route::get('/company-management', [ProviderController::class, 'companyManagement'])->name('company-management');
        Route::get('/employee/{id}', [ProviderController::class, 'employeeProfile'])->name('employee-profile');
        Route::get('/onboarding', [ProviderController::class, 'onboarding'])->name('onboarding');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pending-approvals', [AdminController::class, 'pendingApprovals'])->name('pending-approvals');
        Route::get('/provider-verification/{id}', [AdminController::class, 'providerVerification'])->name('provider-verification');
        Route::get('/service-catalogue', [AdminController::class, 'serviceCatalogueMgmt'])->name('service-catalogue');
        Route::get('/matching', [AdminController::class, 'matchingRequests'])->name('matching');
        Route::get('/complaints', [AdminController::class, 'complaints'])->name('complaints');
        Route::get('/messaging', [AdminController::class, 'messagingOversight'])->name('messaging');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/compliance', [AdminController::class, 'compliance'])->name('compliance');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
    });

    // Company routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('dashboard');
    });

    // Employee routes
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    });
});