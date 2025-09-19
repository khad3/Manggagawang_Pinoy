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
    Schema::create('admin_user_management', function (Blueprint $table) {
        $table->id();

        // User reference
        $table->unsignedBigInteger('user_id'); 
        $table->enum('type_user', ['applicant', 'employer']);

        // Status fields
        $table->enum('status', ['active', 'inactive', 'banned', 'suspended'])->default('active');
        $table->enum('reason', ['pending_investigation', 'multiple_user_reports', 'suspicious_activity'])->nullable();
        $table->text('reason_description')->nullable();

        // Suspension
        $table->integer('suspension_duration')->nullable(); // days
        $table->timestamp('registration_date')->nullable();
        $table->timestamp('last_login')->nullable();

        $table->timestamps();

        // Index for faster queries
        $table->index(['user_id', 'type_user']);
    });
}

public function down(): void
{
    Schema::dropIfExists('admin_user_management');
}



};
