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
    Schema::create('schedule_interview_by_employer', function (Blueprint $table) {
        $table->id();

        // Foreign keys
        $table->unsignedBigInteger('employer_id')->nullable();
        $table->unsignedBigInteger('job_id')->nullable();
        $table->unsignedBigInteger('applicant_id')->nullable();

        // Interview details
        $table->date('date')->nullable();
        $table->time('time')->nullable();
        $table->string('preferred_location')->nullable();
        $table->json('preferred_screening_method')->nullable(); // store multiple methods (array)
        $table->text('additional_notes')->nullable();

        $table->timestamps();

        // Foreign key constraints
        $table->foreign('employer_id')
            ->references('id')
            ->on('employer_account')
            ->onDelete('cascade');

        $table->foreign('job_id')
            ->references('id')
            ->on('job_details_employer')
            ->onDelete('cascade');

        $table->foreign('applicant_id')
            ->references('id')
            ->on('applicants')
            ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('schedule_interview_by_employer');
}

};
