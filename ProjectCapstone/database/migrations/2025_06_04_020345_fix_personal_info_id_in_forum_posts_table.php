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
        Schema::table('forum_posts', function (Blueprint $table) {
            // Drop the incorrectly typed column first (if exists)
            if (Schema::hasColumn('forum_posts', 'personal_info_id')) {
                $table->dropColumn('personal_info_id');
            }
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            // Now re-add the column correctly
            $table->unsignedBigInteger('personal_info_id')->after('applicant_id');
            $table->foreign('personal_info_id')
                ->references('id')
                ->on('personal_info')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropForeign(['personal_info_id']);
            $table->dropColumn('personal_info_id');
        });
    }
};
