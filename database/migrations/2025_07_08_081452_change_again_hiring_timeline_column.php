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
    Schema::table('hiring_timeline', function (Blueprint $table) {
        $table->string('hiring_timeline', 250)->change();
    });
}

public function down(): void
{
    Schema::table('hiring_timeline', function (Blueprint $table) {
        // Clean up data that doesn't match enum values
        DB::table('hiring_timeline')
            ->whereNotIn('hiring_timeline', ['immediate', 'soon', 'month', 'flexible'])
            ->update(['hiring_timeline' => 'flexible']);

        // Revert column type
        $table->enum('hiring_timeline', ['immediate', 'soon', 'month', 'flexible'])->change();
    });
}
};
