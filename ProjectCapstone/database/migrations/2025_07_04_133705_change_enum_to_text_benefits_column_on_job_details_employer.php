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
        Schema::table('job_details_employer', function (Blueprint $table) {
            $table->text('benefits')->nullable()->change(); // Change to text
        });
    }

    public function down(): void
    {
        Schema::table('job_details_employer', function (Blueprint $table) {
            // If your original enum had these values:
            $table->enum('benefits', [
                'SSS Contribution',
                'PhilHealth',
                'Pag-IBIG',
                '13th Month Pay',
                'Overtime Pay',
                'Holiday Pay',
                'Free Meals',
                'Transportation Allowance',
                'Safety Equipment Provided',
                'Skills Training',
                'Performance Bonus',
                'Health Insurance'
            ])->nullable()->change();
        });
    }
};
