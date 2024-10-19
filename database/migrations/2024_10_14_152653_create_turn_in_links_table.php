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
        Schema::create('turn_in_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('turn_in_id');
            $table->text('link');
            $table->timestamps();

            $table->foreign('turn_in_id')->references('id')->on('turn_ins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turn_in_links');
    }
};
