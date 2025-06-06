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
        Schema::create('additional_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_session_id')->constrained(
                table: 'classroom_sessions',
                indexName: 'additional_materials_classroom_session_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained(
                table: 'materials',
                indexName: 'additional_materials_material_id'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_materials');
    }
};
