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
            $table->string('sample_work_url')->nullable()->after('sample_work');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_final_step_register', function (Blueprint $table) {
            $table->dropColumn('sample_work_url');
        });
    }
};
