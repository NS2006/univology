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
        Schema::create('score_components', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name'); // "Final Exam", "Mid Exam", "Assignment"
            $table->unsignedInteger('weight'); // Percentage
            $table->foreignId('course_id')->constrained(
                table: 'courses',
                indexName: 'score_components_course_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score_components');
    }
};
