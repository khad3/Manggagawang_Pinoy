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
        Schema::create('applicants_sample_work_url', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_id');
            $table->unsignedBigInteger('personal_info_id');
            $table->unsignedBigInteger('work_experience_id');
            $table->string('sample_work_title');
            $table->string('sample_work_url');
            $table->timestamps();
            
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('personal_info_id')->references('id')->on('personal_info')->onDelete('cascade');
            $table->foreign('work_experience_id')->references('id')->on('work_experiences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants_sample_work_url');
    }
};
