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
        Schema::table('turn_ins', function (Blueprint $table) {
            // Drop the foreign key constraint if it exists
            $table->dropForeign(['user_id']);

            // Rename the column
            $table->renameColumn('user_id', 'enrollee_id');

            // Add the new foreign key constraint if needed
            $table->foreign('enrollee_id')->references('id')->on('enrollees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turn_ins', function (Blueprint $table) {
             // Drop the foreign key constraint
            $table->dropForeign(['enrollee_id']);

            // Rename the column back
            $table->renameColumn('enrollee_id', 'user_id');

            // Add the original foreign key constraint
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
