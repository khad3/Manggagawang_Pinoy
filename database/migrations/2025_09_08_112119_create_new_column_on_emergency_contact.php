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
        Schema::table('employer_provide_emergency_contact', function (Blueprint $table) {
           $table->enum('relation_to_company', ['Company_Owner', 'Manager/Supervisor', 'Safety-officer', 'HR-representative', 'Business-partner', 'Other'])->nullable()->after('first_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employer_provide_emergency_contact', function (Blueprint $table) {
            $table->dropColumn('relation_to_company');
        });
    }
};
