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
        Schema::create('score_boosters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('bonus');

            $table->foreignId('student_score_id')->constrained(
                table: 'student_scores',
                indexName: 'score_boosters_student_score_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score_boosters');
    }
};
