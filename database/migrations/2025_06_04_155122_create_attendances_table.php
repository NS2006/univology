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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('status')->nullable();
            $table->foreignId('classroom_session_id')->constrained(
                table: 'classroom_sessions',
                indexName: 'attendances_classroom_session_id'
            )->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('enrollment_id')->constrained(
                table: 'enrollments',
                indexName: 'attendances_enrollment_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
