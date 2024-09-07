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
        Schema::table('users', function (Blueprint $table) {
            // Remove the device_token column
            $table->dropColumn('device_token');
            $table->string('cellular')->nullable()->after('lname');

            // Add the soft deletes column
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add the device_token column
            $table->string('device_token')->nullable();
            $table->dropColumn('cellular');
            // Remove the soft deletes column
            $table->dropSoftDeletes();
        });

    }
};
