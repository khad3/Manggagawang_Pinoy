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
    // Add the foreign key if it doesn't exist
    Schema::table('worker_requirements', function (Blueprint $table) {
        // Make sure the column exists and isn't already constrained
        $table->foreign('personal_info_id', 'fk_worker_personal_info')
              ->references('id')
              ->on('employer_personal_info')
              ->onDelete('cascade');
    });
}

public function down(): void
{
    // Only drop the foreign key you created
    Schema::table('worker_requirements', function (Blueprint $table) {
        $table->dropForeign('fk_worker_personal_info');
    });
}


};
