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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('lecturer_id')->constrained(
                table: 'lecturers',
                indexName: 'classrooms_lecturer_id'
            );
            $table->foreignId('course_id')->constrained(
                table: 'courses',
                indexName: 'classrooms_course_id'
            );
            $table->string('class_code');
            $table->string('schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
