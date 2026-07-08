<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date_of_birth')->nullable();
            $table->string('national_health_insurance_number')->nullable();
            $table->decimal('height', 5, 2)->nullable(); // cm
            $table->decimal('weight', 5, 2)->nullable(); // kg
            $table->decimal('bmi', 4, 2)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country', 2)->default('FR');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('health_insurance')->nullable(); // Mutuelle
            $table->string('retirement_fund')->nullable(); // AGIRC-ARRCO, CNAV, etc.
            $table->string('employment_status')->nullable();
            $table->string('family_status')->nullable();
            $table->text('important_life_events')->nullable();
            $table->text('preferences')->nullable();
            $table->text('allergies_warnings')->nullable();
            $table->string('communication_mode')->default('app'); // app, email, phone, sms
            $table->json('consent_settings')->nullable();
            $table->enum('autonomy_level', ['independent', 'slight_help', 'moderate_help', 'significant_help', 'full_dependence'])->default('independent');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};