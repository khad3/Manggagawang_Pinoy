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
    // Add the column ONLY if it doesn't already exist
    if (!Schema::hasColumn('forum_posts', 'personal_info_id')) {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('personal_info_id')->nullable()->after('applicant_id');
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            $table->foreign('personal_info_id')
                ->references('id')
                ->on('personal_info')
                ->onDelete('cascade');
        });
    }
}

public function down(): void
{
    // Check if table and column exist
    if (Schema::hasTable('forum_posts') && Schema::hasColumn('forum_posts', 'personal_info_id')) {

        // Drop the foreign key if it exists using raw SQL
        $fk = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'forum_posts' 
              AND COLUMN_NAME = 'personal_info_id' 
              AND CONSTRAINT_SCHEMA = DATABASE() 
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($fk)) {
            $fkName = $fk[0]->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE forum_posts DROP FOREIGN KEY `$fkName`");
        }

        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropColumn('personal_info_id');
        });
    }
}

};
