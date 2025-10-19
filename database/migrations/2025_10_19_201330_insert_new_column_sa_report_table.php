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
        Schema::table('report_n_i_users', function (Blueprint $table) {
            $table->unsignedBigInteger('employer_id')->nullable()->after('reported_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_n_i_users', function (Blueprint $table) {
            $table->dropColumn('employer_id');
        });
    }
};
