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
        Schema::create('main_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_session_id')->constrained(
                table: 'course_sessions',
                indexName: 'main_materials_course_session_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained(
                table: 'materials',
                indexName: 'main_materials_material_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_materials');
    }
};
