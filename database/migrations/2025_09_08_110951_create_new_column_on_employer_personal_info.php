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
        Schema::table('employer_personal_info', function (Blueprint $table) {
            $table->enum('employer_department', ['Management', 'Human-resource', 'Operations' , 'Project-management' , 'Safety-compliance' , 'Administration' , 'Other'])->nullable()->after('employer_job_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('employer_personal_info', function (Blueprint $table) {
           $table->dropColumn('employer_department');
       });
    }
};
