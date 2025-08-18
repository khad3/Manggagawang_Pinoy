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
            if (!Schema::hasColumn('job_details_employer', 'employer_id')) {
                $table->unsignedBigInteger('employer_id')->nullable()->after('id');
                $table->foreign('employer_id')
                      ->references('id')->on('employer_account')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_details_employer', function (Blueprint $table) {
            if (Schema::hasColumn('job_details_employer', 'employer_id')) {
                $table->dropForeign(['employer_id']);
                $table->dropColumn('employer_id');
            }
        });
    }
};
