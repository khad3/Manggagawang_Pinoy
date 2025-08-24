<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    if (!Schema::hasColumn('group_community', 'applicant_id')) {
        Schema::table('group_community', function (Blueprint $table) {
            $table->unsignedBigInteger('applicant_id')->nullable();
        });

        Schema::table('group_community', function (Blueprint $table) {
            $table->foreign('applicant_id')
                ->references('id')
                ->on('applicants')
                ->onDelete('cascade');
        });
    }

    if (!Schema::hasColumn('group_community', 'personal_info_id')) {
        Schema::table('group_community', function (Blueprint $table) {
            $table->unsignedBigInteger('personal_info_id')->nullable();
        });

        Schema::table('group_community', function (Blueprint $table) {
            $table->foreign('personal_info_id')
                ->references('id')
                ->on('personal_info')
                ->onDelete('cascade');
        });
    }
}



public function down(): void
{
    if (Schema::hasTable('group_community')) {

        // Drop personal_info_id foreign key if exists
        Schema::table('group_community', function (Blueprint $table) {
            DB::statement('ALTER TABLE group_community DROP FOREIGN KEY IF EXISTS group_community_personal_info_id_foreign');
        });

        // Drop column after FK
        if (Schema::hasColumn('group_community', 'personal_info_id')) {
            Schema::table('group_community', function (Blueprint $table) {
                $table->dropColumn('personal_info_id');
            });
        }

        // Drop applicant_id foreign key if exists
        Schema::table('group_community', function (Blueprint $table) {
            DB::statement('ALTER TABLE group_community DROP FOREIGN KEY IF EXISTS group_community_applicant_id_foreign');
        });

        // Drop column after FK
        if (Schema::hasColumn('group_community', 'applicant_id')) {
            Schema::table('group_community', function (Blueprint $table) {
                $table->dropColumn('applicant_id');
            });
        }
    }
}




};
