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
        Schema::table('forum_likes', function (Blueprint $table) {
           $table->boolean('likes')->default(0)->after('applicant_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_likes', function (Blueprint $table) {
            $table->dropColumn('likes');
        });
    }
};
