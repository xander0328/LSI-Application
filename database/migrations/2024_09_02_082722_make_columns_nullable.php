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
        Schema::table('instructors', function (Blueprint $table) {
            $table->string('folder')->nullable()->change();
            $table->string('id_picture')->nullable()->change();
            $table->string('sex')->nullable()->change();
            $table->string('street')->nullable()->change();
            $table->string('barangay')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('province')->nullable()->change();
            $table->string('region')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instructors', function (Blueprint $table) {
            $table->string('folder')->nullable(false)->change();
            $table->string('id_picture')->nullable(false)->change();
            $table->string('sex')->nullable(false)->change();
            $table->string('street')->nullable(false)->change();
            $table->string('barangay')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('province')->nullable(false)->change();
            $table->string('region')->nullable(false)->change();
        });
    }
};
