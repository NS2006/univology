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
        Schema::create('material_progress', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->foreignId('enrollment_id')->constrained(
                table: 'enrollments',
                indexName: 'material_progress_enrollment_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained(
                table: 'materials',
                indexName: 'material_progress_material_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_progress');
    }
};
