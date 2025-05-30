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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); // created_at = enrollment_date
            $table->string('status')->default('active'); # active/completed
            $table->integer('coin')->default(0);
            $table->integer('progress')->default(0);
            $table->decimal('final_score')->nullable();

            $table->foreignId('student_id')->constrained(
                table: 'students',
                indexName: 'enrollment_student_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained(
                table: 'classrooms',
                indexName: 'enrollment_classroom_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
