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
        Schema::create('employer_additional_information', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employer_id')->constrained('employer_account')->onDelete('cascade');
            $table->foreignId('personal_info_id')->constrained('employer_personal_info')->onDelete('cascade');

            $table->string('typical_working_hours')->nullable();
            $table->text('special_intructions_or_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_additional_information');
    }
};
