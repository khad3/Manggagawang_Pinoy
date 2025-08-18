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
        // Example: Drop foreign keys from related tables
        Schema::table('worker_requirements', function (Blueprint $table) {
            $table->dropForeign(['personal_info_id']);
        });

        Schema::table('hiring_timeline', function (Blueprint $table) {
            $table->dropForeign(['personal_info_id']);
        });

        Schema::table('special_requirements_table', function (Blueprint $table) {
            $table->dropForeign(['personal_info_id']);
        });

        // Do the same for all tables referencing employer_personal_info
    }

    public function down(): void
{
    Schema::table('worker_requirements', function (Blueprint $table) {
        $table->foreign('personal_info_id', 'fk_worker_personal_info')
              ->references('id')
              ->on('employer_personal_info')
              ->onDelete('cascade');
    });

    Schema::table('hiring_timeline', function (Blueprint $table) {
        $table->foreign('personal_info_id', 'fk_hiring_personal_info')
              ->references('id')
              ->on('employer_personal_info')
              ->onDelete('cascade');
    });

    Schema::table('special_requirements_table', function (Blueprint $table) {
        $table->foreign('personal_info_id', 'fk_specialreq_personal_info')
              ->references('id')
              ->on('employer_personal_info')
              ->onDelete('cascade');
    });
}


};
