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
        Schema::table('employer_messages_to_applicant', function (Blueprint $table) {
            $table->boolean('is_typing')->default(false)->after('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employer_messages_to_applicant', function (Blueprint $table) {
            $table->dropColumn('is_typing');
        });
    }
};
