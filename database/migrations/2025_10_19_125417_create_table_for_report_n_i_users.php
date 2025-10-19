<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
    Schema::create('report_n_i_users', function (Blueprint $table) {
        $table->id();

        // Reporter information
        $table->unsignedBigInteger('reporter_id');
        $table->enum('reporter_type', ['applicant', 'employer']);

        // Reported account information
        $table->unsignedBigInteger('reported_id');
        $table->enum('reported_type', ['applicant', 'employer']);

        // Report details
        $table->enum('reason', ['fraudulent', 'misleading', 'discriminatory', 'inappropriate', 'other'])->nullable();
        $table->string('other_reason')->nullable();
        $table->string('attachment')->nullable();
        $table->string('additional_info')->nullable();

        $table->timestamps();

        
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_n_i_users');
    }
};
