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
        Schema::create('rating_job_post_by_applicant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_post_id')->nullable();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->integer('rating')->nullable();
            $table->text('review_comments')->nullable();
            $table->timestamps();

            $table->foreign('job_post_id')->references('id')->on('job_details_employer')->onDelete('cascade');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_job_post_by_applicant');
    }
};
