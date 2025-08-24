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
        Schema::create('personal_info', function (Blueprint $table) {
            $table->id(); // personal_info_id
            $table->unsignedBigInteger('applicant_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('house_street');
            $table->string('city');
            $table->string('province');
            $table->string('zipcode');
            $table->string('barangay');
            $table->timestamps();
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_info');
    }
};
