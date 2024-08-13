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
        Schema::table('lessons', function (Blueprint $table) {
            // $table->dropForeign(['batch_id']);
            // $table->dropColumn('batch_id');
            
            $table->unsignedBigInteger('unit_of_competency_id')->after('id')->default(1);
            $table->foreign('unit_of_competency_id')->references('id')->on('unit_of_competencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['unit_of_competency_id']);
            $table->dropColumn('unit_of_competency_id');

            // $table->unsignedBigInteger('batch_id');
            // $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');;
        });
    }
};
