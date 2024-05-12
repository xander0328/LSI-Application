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
        Schema::table('temp_assignments', function (Blueprint $table) {
            $table->dropColumn('path');

            // Add the 'folder' and 'filename' columns
            $table->string('folder')->after('id');
            $table->string('filename')->after('folder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_assignments', function (Blueprint $table) {
            $table->string('path');

            // Drop the 'folder' and 'filename' columns
            $table->dropColumn('folder');
            $table->dropColumn('filename');
        });
    }
};
