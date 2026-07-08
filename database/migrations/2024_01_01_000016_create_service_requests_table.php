<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiary_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete(); // beneficiary or caregiver
            $table->foreignId('service_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('urgency', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('status', ['open', 'matching', 'assigned', 'accepted', 'rejected', 'cancelled', 'paused'])->default('open');
            $table->json('schedule_preference')->nullable();
            $table->string('location')->nullable();
            $table->enum('funding_preference', ['any', 'state_funded', 'reimbursed', 'private', 'mixed', 'retirement_fund'])->default('any');
            $table->decimal('budget_max', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('paused_until')->nullable();
            $table->string('pause_reason')->nullable();
            $table->foreignId('matched_provider_id')->nullable()->constrained('providers')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};