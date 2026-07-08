<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiary_id')->constrained()->cascadeOnDelete();
            $table->foreignId('intervention_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', [
                'missed_visit', 'repeated_refusal', 'provider_note_attention',
                'unusual_inactivity', 'complaint_update', 'appointment_reminder',
                'medication_reminder', 'meal_reminder', 'provider_reminder',
                'unusual_pattern', 'service_completed', 'new_proof_of_service',
                'new_provider_proposal', 'verification_pending', 'unusual_activity',
                'missed_intervention_cluster'
            ]);
            $table->enum('severity', ['info', 'warning', 'critical'])->default('info');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->foreignId('target_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};