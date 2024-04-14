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
        Schema::create('enrollee_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enrollee_id'); // Assuming you have an enrollee table and this is a foreign key
            $table->foreign('enrollee_id')->references('id')->on('enrollees')->onDelete('cascade');
            $table->string('valid_id')->nullable();
            $table->string('diploma_tor')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('id_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollee_files');
    }
};
