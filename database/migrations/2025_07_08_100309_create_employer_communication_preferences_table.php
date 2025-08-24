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
        Schema::create('employer_communication_preferences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employer_id')
                  ->constrained('employer_account')
                  ->onDelete('cascade');

            $table->foreignId('personal_info_id')
                  ->constrained('employer_personal_info')
                  ->onDelete('cascade');

            $table->enum('contact_method', ['email', 'phone', 'sms'])->nullable();
            $table->enum('contact_time', ['morning', 'afternoon', 'evening', 'anytime'])->nullable();
            $table->string('language_preference')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_communication_preferences');
    }
};
