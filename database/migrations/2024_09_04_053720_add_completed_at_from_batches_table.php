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
        Schema::table('batches', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('instructor_id');

            // Drop foreign key constraint if it exists
            $table->dropForeign(['instructor_id']);

            // Change the column to reference the `instructors` table
            $table->unsignedBigInteger('instructor_id')->nullable()->change();
            
            // Add the foreign key constraint to the `instructors` table
            $table->foreign('instructor_id')->references('id')->on('instructors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn('completed_at');

            $table->dropForeign(['instructor_id']);

            // Change the column to reference the `users` table
            $table->unsignedBigInteger('instructor_id')->nullable()->change();
            
            // Add the foreign key constraint to the `users` table
            $table->foreign('instructor_id')->references('id')->on('users');
        });
    }
};
