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
        Schema::create('applicants_portfolio', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->unsignedBigInteger('personal_info_id')->nullable();
            $table->unsignedBigInteger('template_final_step_register_id')->nullable();
            $table->unsignedBigInteger('work_experience_id')->nullable();
            
            $table->string('sample_work_image')->nullable();
            $table->string('sample_work_title')->nullable();
            $table->string('sample_work_description')->nullable();
            $table->string('sample_work_url')->nullable();

            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('personal_info_id')->references('id')->on('personal_info')->onDelete('cascade');
            $table->foreign('template_final_step_register_id')->references('id')->on('template_final_step_register')->onDelete('cascade');
            $table->foreign('work_experience_id')->references('id')->on('work_experiences')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants_portfolio');
    }
};
