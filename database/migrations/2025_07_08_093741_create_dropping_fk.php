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
    if (Schema::hasTable('employer_info_address')) {
        Schema::table('employer_info_address', function (Blueprint $table) {
            $table->dropForeign(['personal_info_id']);
        });
    }

    if (Schema::hasTable('worker_requirements')) {
        try {
            DB::statement('ALTER TABLE worker_requirements DROP FOREIGN KEY fk_worker_personal_info');
        } catch (\Exception $e) {
            // Log or ignore error if FK doesn't exist
        }
    }

    if (Schema::hasTable('hiring_timeline')) {
        try {
            DB::statement('ALTER TABLE hiring_timeline DROP FOREIGN KEY  hiring_timeline_personal_info_id_foreign');
        } catch (\Exception $e) {
            //
        }
    }

    if (Schema::hasTable('special_requirements_table')) {
        try {
            DB::statement('ALTER TABLE special_requirements_table DROP FOREIGN KEY fk_special_personal_info');
        } catch (\Exception $e) {
            //
        }
    }
}

public function down(): void
{
    if (Schema::hasTable('worker_requirements')) {
        try {
            DB::statement('ALTER TABLE worker_requirements DROP FOREIGN KEY fk_worker_personal_info');
        } catch (\Exception $e) {
            //
        }

        Schema::table('worker_requirements', function (Blueprint $table) {
            $table->foreign('personal_info_id', 'fk_worker_personal_info')
                  ->references('id')
                  ->on('employer_personal_info');
        });
    }
}

};
