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
        Schema::table('employer_tesda_certi_priority', function (Blueprint $table) {
            $table->string('tesda_priority')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('employer_tesda_certi_priority', function (Blueprint $table) {
           $table->enum('tesda_priority', ['tesda_only', 'tesda_preferred', 'skills_based'])->change();
       });
    }
};
