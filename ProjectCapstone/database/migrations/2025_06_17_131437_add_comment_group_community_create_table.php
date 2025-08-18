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
        Schema::create('group_community_comments', function (Blueprint $table) {
            $table->id(); // forum_comment_id
            $table->unsignedBigInteger('per_group_community_post_id')->nullable();
            $table->unsignedBigInteger('group_community_id')->nullable();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->unsignedBigInteger('personal_info_id')->nullable();
            $table->text('comment');
            $table->timestamps();
            
            $table->foreign('per_group_community_post_id')->references('id')->on('per_group_posts')->onDelete('cascade');
            $table->foreign('group_community_id')->references('id')->on('group_community')->onDelete('cascade');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('personal_info_id')->references('id')->on('personal_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_community_comments');
    }
};
