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
        Schema::table('template_final_step_register', function (Blueprint $table) {
            $table->text('description')->change()->nullable();
            $table->text('sample_work_url')->change()->nullable();
            $table->text('sample_work')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_final_step_register', function (Blueprint $table) {
            $table->string('description')->change()->nullable();
            $table->string('sample_work_url')->change()->nullable();
            $table->string('sample_work')->change()->nullable();
        });
    }
};
