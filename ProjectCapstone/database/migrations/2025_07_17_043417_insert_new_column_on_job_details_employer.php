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
            $table->string('job_type')->nullable()->after('work_type');
            $table->string('other_department')->nullable()->after('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_details_employer', function (Blueprint $table) {
            $table->dropColumn('job_type');
            $table->dropColumn('other_department');
        });
    }
};
