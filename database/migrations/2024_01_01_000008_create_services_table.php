<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('service_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('funding_type', ['state_funded', 'partially_reimbursed', 'beneficiary_paid', 'mixed', 'retirement_fund', 'to_be_assessed'])->default('beneficiary_paid');
            $table->decimal('base_price', 8, 2)->nullable();
            $table->decimal('reimbursement_amount', 8, 2)->default(0);
            $table->decimal('beneficiary_remainder', 8, 2)->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->text('funding_notes')->nullable();
            $table->json('checklist_template')->nullable(); // proof of service checklist
            $table->json('notes_template')->nullable();
            $table->json('required_documents')->nullable();
            $table->boolean('is_predefined')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};