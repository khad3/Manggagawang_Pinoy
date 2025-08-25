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
        Schema::table('tesda_upload_certification', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->nullable()->after('id');
            $table->foreign('approved_by')->references('id')->on('tesda_officers')->onDelete('set null');

            $table->text('officer_comment')->nullable()->after('approved_by');

            $table->enum('status', ['pending', 'approved', 'rejected' , 'request_revision'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tesda_upload_certification', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
            $table->dropColumn('officer_comment');
        });
    }
};
