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
        Schema::create('turn_in_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('turn_in_id');
            $table->string('folder');
            $table->string('filename');
            $table->string('file_type');
            $table->timestamps();

            // Define foreign key constraints if necessary
            $table->foreign('turn_in_id')->references('id')->on('turn_ins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turn_in_files');
    }
};
