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
        Schema::create('per_group_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_community_id');
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->unsignedBigInteger('personal_info_id')->nullable();
            $table->string('title');
            $table->text('content');
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('personal_info_id')->references('id')->on('personal_info')->onDelete('cascade');
            $table->foreign('group_community_id')->references('id')->on('group_community')->onDelete('cascade');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('per_group_posts');
    }
};
