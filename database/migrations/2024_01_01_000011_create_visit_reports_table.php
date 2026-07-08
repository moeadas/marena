<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained()->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained()->cascadeOnDelete();
            $table->json('checklist_completed')->nullable(); // completed checklist items
            $table->text('notes')->nullable();
            $table->json('photos')->nullable(); // array of file paths
            $table->json('documents')->nullable();
            $table->string('signature')->nullable(); // signature image path
            $table->enum('service_outcome', ['fully_completed', 'partially_completed', 'not_completed', 'rescheduled'])->default('fully_completed');
            $table->text('recommended_next_action')->nullable();

            // Quality of life observations
            $table->enum('mood', ['good', 'neutral', 'low', 'concerning'])->nullable();
            $table->enum('appetite', ['good', 'medium', 'low', 'none'])->nullable();
            $table->enum('mobility', ['good', 'limited', 'assisted', 'bedridden'])->nullable();
            $table->enum('engagement', ['active', 'responsive', 'passive', 'withdrawn'])->nullable();
            $table->enum('hydration', ['good', 'adequate', 'low', 'dehydrated'])->nullable();
            $table->text('loneliness_signs')->nullable();
            $table->text('environmental_concerns')->nullable();

            // Vital signs (for medical professionals)
            $table->integer('blood_pressure_systolic')->nullable();
            $table->integer('blood_pressure_diastolic')->nullable();
            $table->integer('blood_glucose')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('oxygen_saturation')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('pain_level')->nullable(); // 0-10
            $table->text('cognitive_status')->nullable();

            $table->boolean('is_family_summary_generated')->default(false);
            $table->text('family_summary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_reports');
    }
};