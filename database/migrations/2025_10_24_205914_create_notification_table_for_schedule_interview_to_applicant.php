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
        Schema::create('notification_for_applicant_interview', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->default('schedule_interview');
            $table->text('message')->nullable();

            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('receiver_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('employer_account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_for_applicant_interview');
    }
};
