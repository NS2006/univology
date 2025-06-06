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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('deadline')->nullable();
            $table->boolean('is_published')->default(false);
            $table->text('title');
            $table->uuid('assignment_id')->unique();

            $table->foreignId('classroom_id')->constrained(
                table: 'classrooms',
                indexName: 'assignments_classroom_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
