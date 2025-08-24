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
        Schema::create('tesda_upload_certification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_id');
           // File upload (store file path, not actual file)
            $table->string('file_path')->nullable();

            // Certification details
            $table->string('certification_program')->nullable();
            $table->string('certification_number')->nullable();
            $table->string('certification_program_other')->nullable();

            // Use date type instead of string for proper queries
            $table->date('certification_date_obtained')->nullable();
            $table->timestamps();

            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tesda_upload_certification');
    }
};
