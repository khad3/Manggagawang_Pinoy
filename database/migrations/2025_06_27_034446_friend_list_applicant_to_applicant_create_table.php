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
        Schema::create('applicant_to_applicant_friend_list', function (Blueprint $table) {
            
            $table->id();   
            $table->unsignedBigInteger('request_id')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_to_applicant_friend_list');
    }
};
