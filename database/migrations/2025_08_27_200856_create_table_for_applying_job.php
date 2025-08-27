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
    Schema::create('applying_job_to_employers', function (Blueprint $table) {
        $table->id();

        // Foreign keys
        $table->foreignId('job_id')
              ->constrained('job_details_employer')
              ->cascadeOnDelete();

        $table->foreignId('applicant_id')
              ->constrained('applicants')
              ->cascadeOnDelete();

        // Application details
        $table->text('cover_letter')->nullable();
        $table->string('resume')->nullable(); // path to resume file
        $table->string('tesda_certification')->nullable(); // path to TESDA file
        $table->string('cellphone_number', 20)->nullable();
        $table->text('additional_information')->nullable();

        // Application status (0 = pending, 1 = approved, 2 = rejected maybe)
        $table->enum('status', ['pending', 'approved', 'rejected'])->default(value: 'pending');

        // Prevent duplicate applications
        $table->unique(['job_id', 'applicant_id']);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applying_job_to_employers');
    }
};
