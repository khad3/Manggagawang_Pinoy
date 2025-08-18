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
        Schema::table('group_community_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('work_experience_id')->nullable()->after('personal_info_id');
            $table->foreign('work_experience_id')->references('id')->on('work_experiences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_community_comments', function (Blueprint $table) {
            $table->dropForeign(['work_experience_id']);
            $table->dropColumn('work_experience_id');
        });
    }
};
