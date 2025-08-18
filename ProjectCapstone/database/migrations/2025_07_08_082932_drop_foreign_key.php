<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     //update not drop
  public function up(): void
{
  Schema::dropIfExists('special_requirementsss_table');
}


   public function down(): void
{
    Schema::create('special_requirementsss_table', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('personal_info_id');
        $table->unsignedBigInteger('employer_id');
        $table->json('special_requirements')->nullable();
        $table->text('additional_requirements_or_notes')->nullable();
        $table->timestamps();

        $table->foreign('employer_id')->references('id')->on('employer_account')->onDelete('cascade');
        $table->foreign('personal_info_id')->references('id')->on('employer_personal_info')->onDelete('cascade');
    });
}





};
