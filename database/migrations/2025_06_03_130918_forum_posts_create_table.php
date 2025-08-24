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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id(); // forum_post_id
            $table->unsignedBigInteger('applicant_id');
            $table->string('title');
            $table->text('content');
            $table->string('image_path')->nullable();
            $table->timestamps();


            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
    }
};
