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
        Schema::table('job_details_employer', function (Blueprint $table) {
            // Change none_certifications_qualification to TEXT for multiple values
            $table->text('none_certifications_qualification')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_details_employer', function (Blueprint $table) {
            // Revert back to ENUM (or string) with your original options
            $table->enum('none_certifications_qualification', [
                'At least 1 year work experience',
                'Strong teamwork and collaboration',
                'Good communication skills',
                'Flexible and adaptable',
                'Other' // if you had an "Other" option
            ])->nullable()->change();
        });
    }

};
