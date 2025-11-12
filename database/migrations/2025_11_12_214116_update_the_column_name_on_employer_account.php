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
        Schema::table('employer_personal_info', function (Blueprint $table) {
            $table->string('employer_job_title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employer_personal_info', function (Blueprint $table) {
            $table->string('employer_job_title')->nullable(false)->change();
        });
    }
};
