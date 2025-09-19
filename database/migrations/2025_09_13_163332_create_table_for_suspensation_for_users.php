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
        Schema::create('suspended_users_table', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->unsignedBigInteger('employer_id')->nullable();
            $table->enum('reason', ['pending_investigation', 'multiple_user_reports', 'suspicious_activity', 'other'])->nullable();
            $table->text('other_reason')->nullable();
            $table->text('additional_info')->nullable();
            $table->integer('suspension_duration')->nullable(); // Duration in days
            $table->timestamps();

            
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('employer_id')->references('id')->on('employer_account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspended_users_table');
    }
};
