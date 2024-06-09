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
        Schema::create('enrollee_qrcodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enrollee_id');
            $table->text('qr_code');
            $table->timestamps();

            $table->foreign('enrollee_id')->references('id')->on('enrollees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollee_qrcodes');
    }
};
