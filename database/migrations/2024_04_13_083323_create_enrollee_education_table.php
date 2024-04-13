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
        Schema::create('enrollee_education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enrollee_id');
            $table->foreign('enrollee_id')->references('id')->on('enrollees')->onDelete('cascade');
            $table->string('school_name')->required();
            $table->string('educational_level')->required();
            $table->string('school_year')->required(); // Example: 2020-2024
            $table->string('degree')->nullable();
            $table->string('minor')->nullable();
            $table->string('major')->nullable();
            $table->integer('units_earned')->nullable();
            $table->string('honors_received')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollee_education');
    }
};
