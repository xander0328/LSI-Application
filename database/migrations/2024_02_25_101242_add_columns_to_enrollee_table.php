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
            $table->string('id_picture', 255)->after('course_id');
            $table->string('street', 255);
            $table->string('barangay', 255);
            $table->string('district', 255);
            $table->string('city', 255);
            $table->string('province', 255);
            $table->string('region', 255);
            $table->string('zip', 255);
            $table->string('box_no', 255);
            $table->string('sex', 255);
            $table->string('civil_status', 255);
            $table->string('telephone', 255);
            $table->string('cellular', 255);
            $table->string('email', 255);
            $table->string('employment_type', 255);
            $table->string('employment_status', 255);
            $table->timestamp('birth_date');
            $table->string('birth_place', 255);
            $table->string('citizenship', 255);
            $table->string('religion', 255);
            $table->integer('height');
            $table->integer('weight');
            $table->string('blood_type', 255);
            $table->string('sss', 255);
            $table->string('gsis', 255);
            $table->string('tin', 255);
            $table->string('disting_marks', 255);
            $table->string('preferred_schedule', 255);
            $table->timestamp('preferred_start');
            $table->timestamp('preferred_finish',);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollees', function (Blueprint $table) {
            //
        });
    }
};
