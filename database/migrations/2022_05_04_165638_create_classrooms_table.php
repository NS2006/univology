<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            )->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->foreignId('course_id')->constrained(
                table: 'courses',
                indexName: 'classrooms_course_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->uuid('class_id')->unique();
            $table->string('class_code');
            $table->string('schedule');
            $table->text('online_link');
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
