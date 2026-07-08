<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('profession')->nullable(); // nurse, physiotherapist, home_help, etc.
            $table->string('specialty')->nullable();
            $table->string('company_name')->nullable();
            $table->boolean('is_independent')->default(true);
            $table->foreignId('company_id')->nullable(); // links to companies table if employee
            $table->string('registration_number')->nullable(); // RPPS, ADELI, FINESS
            $table->string('licence_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('service_area')->nullable(); // geographic coverage
            $table->enum('verification_status', ['pending', 'under_review', 'approved', 'rejected'])->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('verification_notes')->nullable();
            $table->json('documents')->nullable(); // licences, insurance, certifications
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->integer('completion_rate')->default(0); // percentage
            $table->integer('response_time_avg')->nullable(); // minutes
            $table->json('trust_markers')->nullable(); // verified badge, doc validated, etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};