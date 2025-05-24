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
        Schema::create('classroom_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->uuid('classroom_session_id')->unique();
            $table->integer('is_finished')->default(0);
            
            $table->foreignId('classroom_id')->constrained(
                table: 'classrooms',
                indexName: 'classroom_sessions_classroom_id'
            );

            $table->foreignId('course_session_id')->constrained(
                table: 'course_sessions',
                indexName: 'classroom_sessions_course_session_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_sessions');
    }
};
