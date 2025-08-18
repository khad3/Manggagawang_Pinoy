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
         Schema::table('employer_tesda_certi_priority', function (Blueprint $table) {
            $table->string('tesda_priority')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    // Clean up invalid values before converting back to enum
    DB::table('employer_tesda_certi_priority')
        ->whereNotIn('tesda_priority', ['tesda_only', 'tesda_preferred', 'skills_based'])
        ->update(['tesda_priority' => 'skills_based']); // fallback value

    Schema::table('employer_tesda_certi_priority', function (Blueprint $table) {
        $table->enum('tesda_priority', ['tesda_only', 'tesda_preferred', 'skills_based'])->change();
    });
}
};
