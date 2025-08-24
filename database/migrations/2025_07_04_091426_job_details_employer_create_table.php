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
    Schema::create('job_details_employer', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('department')->nullable(); 
        $table->string('location');
        $table->string('work_type');
        $table->string('experience_level');
        $table->string('job_salary')->nullable(); 
        $table->text('job_description');
        $table->text('additional_requirements')->nullable();

        // Store arrays as JSON for TESDA, other certs, and benefits
        $table->json('tesda_certification')->nullable(); 
        $table->string('other_certifications')->nullable();
        $table->boolean('none_certifications')->default(false); // true if "None Certification" is checked
        $table->json('none_certifications_qualification')->nullable(); 
        $table->json('benefits')->nullable(); 
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_details_employer');
    }
};
