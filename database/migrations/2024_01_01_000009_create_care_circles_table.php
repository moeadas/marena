<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Care Circle - links beneficiaries with caregivers, providers, family
        Schema::create('care_circles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiary_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // the member (caregiver, provider, family)
            $table->enum('member_type', ['caregiver', 'provider', 'family', 'admin']);
            $table->enum('relationship', ['spouse', 'child', 'sibling', 'parent', 'legal_representative', 'trusted_contact', 'other'])->nullable();
            $table->json('permissions')->nullable(); // view_only, message_providers, manage_schedule, approve_services, receive_alerts
            $table->enum('status', ['active', 'pending', 'invited', 'revoked'])->default('active');
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->unique(['beneficiary_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('care_circles');
    }
};