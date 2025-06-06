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
        Schema::create('student_scores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('score')->nullable();

            $table->foreignId('score_component_id')->constrained(
                table: 'score_components',
                indexName: 'student_scores_score_component_id'
            )->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('enrollment_id')->constrained(
                table: 'enrollments',
                indexName: 'student_scores_enrollment_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_scores');
    }
};
