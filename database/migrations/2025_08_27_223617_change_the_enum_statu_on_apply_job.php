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
    Schema::table('applying_job_to_employers', function (Blueprint $table) {
        $table->enum('status', ['pending', 'being_reviewed', 'interview', 'rejected' , 'approved'])
              ->default('pending')
              ->change();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('applying_job_to_employers', function (Blueprint $table) {
        $table->enum('status', ['pending', 'approved', 'rejected'])
              ->default('pending')
              ->change();
    });
}

};
