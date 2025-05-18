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
        Schema::create('main_material_progress', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->foreignId('enrollment_id')->constrained(
                table: 'enrollments',
                indexName: 'main_material_progress_enrollment_id'
            );
            $table->foreignId('main_material_id')->constrained(
                table: 'main_materials',
                indexName: 'main_material_progress_main_material_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_material_progress');
    }
};
