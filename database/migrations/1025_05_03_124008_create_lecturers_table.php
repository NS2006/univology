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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('lecturer_id')->unique();
            $table->string('email')->unique();
            $table->foreignId('user_id')->constrained(
                table: 'users',
                indexName: 'lecturers_user_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('faculty_id')->constrained(
                table: 'faculties',
                indexName: 'lecturers_faculty_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
