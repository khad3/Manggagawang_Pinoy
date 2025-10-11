<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void
    {
        // Get existing foreign keys
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'employer_provide_emergency_contact' 
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ");

        // Drop all foreign keys
        foreach ($foreignKeys as $fk) {
            DB::statement("ALTER TABLE employer_provide_emergency_contact DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
        }

        Schema::table('employer_provide_emergency_contact', function (Blueprint $table) {
            // Make columns nullable AND unsigned (if parent tables use unsigned)
            $table->unsignedBigInteger('employer_id')->nullable()->change();
            $table->unsignedBigInteger('personal_info_id')->nullable()->change();
            $table->string('first_name')->nullable()->change();
            $table->string('relation_to_company')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
        });

        Schema::table('employer_provide_emergency_contact', function (Blueprint $table) {
            // Re-add foreign keys
            $table->foreign('employer_id')
                  ->references('id')
                  ->on('employer_account')
                  ->onDelete('cascade');
                  
            $table->foreign('personal_info_id')
                  ->references('id')
                  ->on('employer_personal_info')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Get existing foreign keys
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'employer_provide_emergency_contact' 
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ");

        // Drop all foreign keys
        foreach ($foreignKeys as $fk) {
            DB::statement("ALTER TABLE employer_provide_emergency_contact DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
        }

        Schema::table('employer_provide_emergency_contact', function (Blueprint $table) {
            // Revert columns back to NOT NULL
            $table->unsignedBigInteger('employer_id')->nullable(false)->change();
            $table->unsignedBigInteger('personal_info_id')->nullable(false)->change();
            $table->string('first_name')->nullable(false)->change();
            $table->string('relation_to_company')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
        });

        Schema::table('employer_provide_emergency_contact', function (Blueprint $table) {
            // Re-add foreign keys
            $table->foreign('employer_id')
                  ->references('id')
                  ->on('employer_account')
                  ->onDelete('cascade');
                  
            $table->foreign('personal_info_id')
                  ->references('id')
                  ->on('employer_personal_info')
                  ->onDelete('cascade');
        });
    }
};

