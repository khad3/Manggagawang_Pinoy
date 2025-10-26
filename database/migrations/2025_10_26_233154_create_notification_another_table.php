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
        Schema::create('notifications_sa_lahat', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['admin', 'employer', 'applicant', 'tesda_officer'])->index();

            $table->unsignedBigInteger('type_id')->nullable()->index();
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->string('link')->nullable();
            $table->timestamps();

            $table->index(['type', 'type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_sa_lahat');
    }
};
