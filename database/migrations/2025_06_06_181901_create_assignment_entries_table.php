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
        Schema::create('assignment_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->boolean('is_finished')->default(false);

            $table->foreignId('enrollment_id')->constrained(
                table: 'enrollments',
                indexName: 'assignment_entries_enrollment_id'
            )->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('assignment_id')->constrained(
                table: 'assignments',
                indexName: 'assignment_entries_assignment_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_entries');
    }
};
