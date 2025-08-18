<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employer_account', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->timestamps();
        });

        Schema::create('employer_personal_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employer_account')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('employer_job_title');
            $table->string('employer_department')->nullable();
            $table->timestamps();
        });

        Schema::create('employer_info_address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employer_account')->onDelete('cascade');
            $table->foreignId('personal_info_id')->constrained('employer_personal_info')->onDelete('cascade');
            $table->string('company_name');
            $table->string('company_complete_address');
            $table->string('company_municipality');
            $table->string('company_province');
            $table->string('company_zipcode');
            $table->timestamps();
        });

        Schema::create('employer_provide_emergency_contact', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employer_account')->onDelete('cascade');
            $table->foreignId('personal_info_id')->constrained('employer_personal_info')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->timestamps();
        });

        Schema::create('employer_communication_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employer_account')->onDelete('cascade');
            $table->foreignId('personal_info_id')->constrained('employer_personal_info')->onDelete('cascade');
            $table->enum('contact_method', ['email', 'phone', 'sms'])->nullable();
            $table->enum('contact_time', ['morning', 'afternoon', 'evening', 'anytime'])->nullable();
            $table->string('language_preference')->nullable();
            $table->timestamps();
        });

        Schema::create('employer_additional_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employer_account')->onDelete('cascade');
            $table->foreignId('personal_info_id')->constrained('employer_personal_info')->onDelete('cascade');
            $table->string('typical_working_hours')->nullable();
            $table->text('special_intructions_or_notes')->nullable();
            $table->timestamps();
        });
    }

 public function down(): void
{
    // Drop child tables that reference employer_personal_info
    Schema::dropIfExists('employer_additional_information');
    Schema::dropIfExists('employer_communication_preferences');
    Schema::dropIfExists('employer_provide_emergency_contact');
    Schema::dropIfExists('employer_info_address');

    // Now it's safe to drop parent tables
    Schema::dropIfExists('employer_personal_info');
    Schema::dropIfExists('employer_account');
}


};
