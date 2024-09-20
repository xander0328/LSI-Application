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
        Schema::table('enrollees', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('telephone');
            $table->dropColumn('cellular');
            $table->dropColumn('box_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollees', function (Blueprint $table) {
            $table->string('telephone', 255);
            $table->string('cellular', 255);
            $table->string('email', 255);
            $table->string('box_no', 255);
        });
    }
};
