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
            $table->dropForeign(['instructor_id']);
            
            $table->dropColumn('instructor_id');
            $table->dropColumn('conctact_number');
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('folder')->after('user_id');
            $table->string('id_picture')->after('folder');
            $table->string('sex')->after('id_picture');
            $table->date('submitted')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            
            $table->dropColumn('user_id');
            $table->dropColumn('sex');
            $table->dropColumn('folder');
            $table->dropColumn('id_picture');
            $table->dropColumn('submitted');
            
            $table->foreignId('instructor_id')->constrained()->onDelete('cascade')->after('id');
            
            // $table->string('conctact_number')->after('instructor_id');
            $table->string('conctact_number');
        });
    }
};
