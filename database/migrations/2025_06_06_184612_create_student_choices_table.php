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
        Schema::create('student_choices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('assignment_entry_id')->constrained(
                table: 'assignment_entries',
                indexName: 'student_choices_assignment_entry_id'
            )->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('choice_id')->constrained(
                table: 'choices',
                indexName: 'student_choices_choice_id'
            )->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('question_id')->constrained(
                table: 'questions',
                indexName: 'student_choices_question_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_choices');
    }
};
