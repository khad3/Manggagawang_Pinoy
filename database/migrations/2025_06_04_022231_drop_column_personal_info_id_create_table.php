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
        $table->dropForeign(['personal_info_id']); // Drop the FK constraint
        $table->dropColumn('personal_info_id');    // Drop the column
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('forum_posts', function (Blueprint $table) {
        // Add the column back (adjust the type as originally defined)
        $table->unsignedBigInteger('personal_info_id')->nullable();

        // Restore the foreign key constraint
        $table->foreign('personal_info_id')->references('id')->on('personal_info')->onDelete('cascade');
    });
}

};
