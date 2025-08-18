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
        Schema::table('hiring_timeline', function (Blueprint $table) {
            $table->string('hiring_timeline' , 250)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hiring_timeline', function (Blueprint $table) {
            $table->enum('hiring_timeline', ['immediate', 'soon', 'month', 'flexible'])->change();
        });
    }
};
