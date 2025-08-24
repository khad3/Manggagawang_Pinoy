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
        Schema::create('hiring_timeline', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personal_info_id');
            $table->unsignedBigInteger('employer_id');

            $table->enum('hiring_timeline', ['immediate', 'soon', 'month', 'flexible'])->default('flexible');
            $table->timestamps();

            $table->foreign('employer_id')->references('id')->on('employer_account')->onDelete('cascade');
            $table->foreign('personal_info_id')->references('id')->on('employer_personal_info')->onDelete('cascade');
        });

        Schema::create('worker_requirements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('personal_info_id');
            $table->unsignedBigInteger('employer_id');


            $table->string('number_of_workers');
            $table->string('project_duration');
            $table->json('skill_requirements')->nullable();
            $table->timestamps();

            $table->foreign('employer_id')->references('id')->on('employer_account')->onDelete('cascade');
            $table->foreign('personal_info_id')->references('id')->on('employer_personal_info')->onDelete('cascade');
        });

        Schema::create('worker_interview_preference', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('personal_info_id');
            $table->unsignedBigInteger('employer_id');

            $table->json('preferred_screening_method')->nullable();
            $table->string('preferred_interview_location')->nullable();
            $table->timestamps();

            $table->foreign('employer_id')->references('id')->on('employer_account')->onDelete('cascade');
            $table->foreign('personal_info_id')->references('id')->on('employer_personal_info')->onDelete('cascade');


        });


        Schema::create('special_requirements_table', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('personal_info_id');
            $table->unsignedBigInteger('employer_id');

            $table->json('special_requirements')->nullable();
            $table->text('additional_requirements_or_notes')->nullable();
            $table->timestamps();

            $table->foreign('employer_id')->references('id')->on('employer_account')->onDelete('cascade');
            $table->foreign('personal_info_id')->references('id')->on('employer_personal_info')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiring_timeline');
        Schema::dropIfExists('worker_requirements');
        Schema::dropIfExists('worker_interview_preference');
        Schema::dropIfExists('special_requirements_table');
    }
};
