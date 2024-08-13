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
        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('category', 'course_category_id');
            $table->unsignedBigInteger('course_category_id')->change();
            
            $table->string('structure')->after('description');
        });

        DB::table('courses')->update(['structure' => 'big']);

        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('course_category_id')->references('id')->on('course_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['course_category_id']);
            
            $table->renameColumn('course_category_id', 'category');
            
            $table->dropColumn('structure');
        });
    }
};
