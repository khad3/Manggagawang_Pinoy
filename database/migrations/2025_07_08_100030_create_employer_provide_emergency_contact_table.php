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
        Schema::create('employer_provide_emergency_contact', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employer_id')
                  ->constrained('employer_account')
                  ->onDelete('cascade');

            $table->foreignId('personal_info_id')
                  ->constrained('employer_personal_info')
                  ->onDelete('cascade');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_provide_emergency_contact');
    }
};
