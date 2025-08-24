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
       Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_id');
            $table->string('position');
            $table->string('other_position')->nullable();
            $table->integer('work_duration')->nullable(); // e.g., 2
            $table->enum('work_duration_unit', ['months', 'years'])->nullable(); // e.g., years or months
            $table->enum('employed', ['Yes', 'No'])->nullable();
            $table->string('profileimage_path')->nullable(); // made nullable just in case
            $table->timestamps();
            
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
