<?php

use Illuminate\Database\Eloquent\Attributes\Scope;
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
    if (!Schema::hasColumn('group_participants', 'personal_info_id')) {
        Schema::table('group_participants', function (Blueprint $table) {
            $table->unsignedBigInteger('personal_info_id')->nullable();

            $table->foreign('personal_info_id')
                  ->references('id')
                  ->on('personal_info')
                  ->onDelete('cascade');
        });
    }
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('group_participants', function (Blueprint $table) {
        // Drop the foreign key first (safe)
        if (Schema::hasColumn('group_participants', 'personal_info_id')) {
            $table->dropForeign(['personal_info_id']);
            $table->dropColumn('personal_info_id');
        }
    });
}

};
