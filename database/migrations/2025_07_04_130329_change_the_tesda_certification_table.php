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
        // Change tesda_certification from ENUM to TEXT
        $table->text('tesda_certification')->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('job_details_employer', function (Blueprint $table) {
        // Revert to ENUM and keep it nullable
        $table->enum('tesda_certification', [
            'Welding (SMAW/GMAW/GTAW)',
            'Electrical Installation & Maintenance',
            'Plumbing Installation & Maintenance',
            'Carpentry & Joinery',
            'Automotive Servicing',
            'HVAC Installation & Servicing',
            'Other'
        ])->nullable()->change();
    });
}

};
