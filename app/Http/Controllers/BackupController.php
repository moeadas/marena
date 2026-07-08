<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Models\Beneficiary;
use App\Models\CareCircle;
use App\Models\Intervention;
use App\Models\VisitReport;
use App\Models\Message;
use App\Models\Alert;
use App\Models\Reminder;
use App\Models\Document;
use App\Models\ServiceRequest;
use App\Models\Complaint;
use App\Models\ProviderReview;
use App\Models\ProviderAvailability;
use App\Models\CrossProfessionalRequest;
use App\Models\ConsentLog;
use App\Models\AuditLog;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Provider;
use App\Models\Company;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\EmergencyContact;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BackupController extends Controller
{
    public function export(Request $request)
    {
        $user = Auth::user();
        $timestamp = now()->format('Y-m-d_His');
        $filename = "marena_backup_{$timestamp}.json";

        $data = [
            'meta' => [
                'exported_at' => now()->toISOString(),
                'exported_by' => $user->name ?? $user->email,
                'version' => '1.0',
                'app' => 'MARÉNA Care',
            ],
            'roles' => DB::table('roles')->get()->toArray(),
            'users' => User::all()->toArray(),
            'beneficiaries' => Beneficiary::all()->toArray(),
            'emergency_contacts' => EmergencyContact::all()->toArray(),
            'providers' => Provider::all()->toArray(),
            'companies' => Company::all()->toArray(),
            'service_categories' => ServiceCategory::all()->toArray(),
            'services' => Service::all()->toArray(),
            'care_circles' => CareCircle::all()->toArray(),
            'interventions' => Intervention::all()->toArray(),
            'visit_reports' => VisitReport::all()->toArray(),
            'conversations' => Conversation::all()->toArray(),
            'messages' => Message::all()->toArray(),
            'alerts' => Alert::all()->toArray(),
            'reminders' => Reminder::all()->toArray(),
            'documents' => Document::all()->toArray(),
            'service_requests' => ServiceRequest::all()->toArray(),
            'cross_professional_requests' => CrossProfessionalRequest::all()->toArray(),
            'complaints' => Complaint::all()->toArray(),
            'provider_availability' => ProviderAvailability::all()->toArray(),
            'provider_reviews' => ProviderReview::all()->toArray(),
            'subscriptions' => Subscription::all()->toArray(),
            'audit_logs' => AuditLog::all()->toArray(),
            'consent_logs' => ConsentLog::all()->toArray(),
        ];

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Log the backup
        Backup::create([
            'user_id' => $user->id,
            'filename' => $filename,
            'file_path' => "backups/{$filename}",
            'file_size' => strlen($json),
            'type' => 'manual',
            'metadata' => json_encode(['tables' => count($data) - 1]),
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'backup_exported',
            'model_type' => 'Backup',
            'ip_address' => $request->ip(),
        ]);

        return response()->streamDownload(function () use ($json) {
            echo $json;
        }, $filename, ['Content-Type' => 'application/json']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:json,txt|max:50000',
        ]);

        $user = Auth::user();
        $file = $request->file('backup_file');
        $content = file_get_contents($file->getRealPath());
        $data = json_decode($content, true);

        if (!$data || !isset($data['meta'])) {
            return back()->with('error', 'Invalid backup file format.');
        }

        DB::transaction(function () use ($data, $user, $request) {
            DB::statement('PRAGMA foreign_keys = OFF');

            $tables = [
                'visit_reports', 'cross_professional_requests', 'complaints',
                'provider_reviews', 'provider_availability', 'service_requests',
                'reminders', 'alerts', 'messages', 'conversations',
                'documents', 'interventions', 'care_circles', 'services',
                'service_categories', 'emergency_contacts', 'providers',
                'companies', 'beneficiaries', 'subscriptions',
                'consent_logs', 'audit_logs', 'backups',
            ];

            foreach ($tables as $table) {
                if (!isset($data[$table])) continue;
                DB::table($table)->truncate();
                foreach ($data[$table] as $row) {
                    unset($row['pivot']);
                    DB::table($table)->insert($row);
                }
            }

            DB::statement('PRAGMA foreign_keys = ON');

            Backup::create([
                'user_id' => $user->id,
                'filename' => $data['meta']['exported_at'] ?? 'imported',
                'file_path' => 'imported',
                'file_size' => strlen(json_encode($data)),
                'type' => 'import',
                'metadata' => json_encode(['imported_at' => now()->toISOString()]),
            ]);

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'backup_imported',
                'model_type' => 'Backup',
                'ip_address' => $request->ip(),
            ]);
        });

        return back()->with('success', 'Data imported successfully from backup.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'confirm' => 'required|accepted',
        ]);

        $user = Auth::user();

        if ($user->role?->name !== 'admin') {
            return back()->with('error', 'Only administrators can delete all data.');
        }

        DB::transaction(function () use ($user, $request) {
            DB::statement('PRAGMA foreign_keys = OFF');

            $tables = [
                'visit_reports', 'cross_professional_requests', 'complaints',
                'provider_reviews', 'provider_availability', 'service_requests',
                'reminders', 'alerts', 'messages', 'conversations',
                'documents', 'interventions', 'care_circles', 'services',
                'service_categories', 'emergency_contacts', 'providers',
                'companies', 'beneficiaries', 'subscriptions',
                'consent_logs', 'audit_logs', 'backups',
            ];

            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }

            // Delete all users except the current admin
            DB::table('users')->where('id', '!=', $user->id)->delete();

            DB::statement('PRAGMA foreign_keys = ON');

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'all_data_deleted',
                'model_type' => 'System',
                'ip_address' => $request->ip(),
                'new_values' => json_encode(['deleted_by' => $user->email]),
            ]);
        });

        return back()->with('success', 'All data has been deleted. The system is now fresh.');
    }
}