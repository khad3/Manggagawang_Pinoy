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
    Schema::create('employer_messages_to_applicant', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('employer_id');   // sender
        $table->unsignedBigInteger('applicant_id');  // receiver
        $table->longText('message')->nullable();     // safer for long messages
        $table->string('attachment')->nullable();    // for images/files
        $table->enum('sender_type', ['employer', 'applicant'])->nullable();
        $table->boolean('is_read')->default(false);
        $table->timestamps();

        $table->foreign('employer_id')
              ->references('id')->on('employer_account') 
              ->onDelete('cascade');

        $table->foreign('applicant_id')
              ->references('id')->on('applicants')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_messages_to_applicant');
    }
};
