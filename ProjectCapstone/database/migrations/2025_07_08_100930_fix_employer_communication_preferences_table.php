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
        Schema::table('employer_communication_preferences', function (Blueprint $table) {
            if (!Schema::hasColumn('employer_communication_preferences', 'employer_id')) {
                $table->foreignId('employer_id')->after('id')->constrained('employer_account')->onDelete('cascade');
            }

            if (!Schema::hasColumn('employer_communication_preferences', 'personal_info_id')) {
                $table->foreignId('personal_info_id')->after('employer_id')->constrained('employer_personal_info')->onDelete('cascade');
            }

            if (!Schema::hasColumn('employer_communication_preferences', 'contact_method')) {
                $table->enum('contact_method', ['email', 'phone', 'sms'])->nullable()->after('personal_info_id');
            }

            if (!Schema::hasColumn('employer_communication_preferences', 'contact_time')) {
                $table->enum('contact_time', ['morning', 'afternoon', 'evening', 'anytime'])->nullable()->after('contact_method');
            }

            if (!Schema::hasColumn('employer_communication_preferences', 'language_preference')) {
                $table->string('language_preference')->nullable()->after('contact_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employer_communication_preferences', function (Blueprint $table) {
            if (Schema::hasColumn('employer_communication_preferences', 'employer_id')) {
                $table->dropForeign(['employer_id']);
                $table->dropColumn('employer_id');
            }

            if (Schema::hasColumn('employer_communication_preferences', 'personal_info_id')) {
                $table->dropForeign(['personal_info_id']);
                $table->dropColumn('personal_info_id');
            }

            if (Schema::hasColumn('employer_communication_preferences', 'contact_method')) {
                $table->dropColumn('contact_method');
            }

            if (Schema::hasColumn('employer_communication_preferences', 'contact_time')) {
                $table->dropColumn('contact_time');
            }

            if (Schema::hasColumn('employer_communication_preferences', 'language_preference')) {
                $table->dropColumn('language_preference');
            }
        });
    }

};
