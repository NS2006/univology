<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialProgress extends Model
{
    protected $guarded = ['id'];

    protected $with = ['enrollment', 'material'];

    public function enrollment(): BelongsTo{
        return $this->belongsTo(Enrollment::class);
    }

    public function material(): BelongsTo{
        return $this->belongsTo(MainMaterial::class);
    }

    public static function calculateProgress(Enrollment $enrollment, Classroom $classroom){
        $mainMaterialIds = $classroom->course->course_sessions
            ->flatMap(function ($session) {
                return $session->main_materials;
            })->pluck('material_id');


        $additionalMaterialIds = $classroom->classroom_sessions
            ->flatMap(function ($session) {
                return $session->additional_materials;
            })->pluck('material_id');


        $allMaterialIds = $mainMaterialIds->merge($additionalMaterialIds)->unique();


        $total = $allMaterialIds->count();


        $finishedCount = MaterialProgress::where('enrollment_id', $enrollment->id)
            ->whereIn('material_id', $allMaterialIds)
            ->where('status', true)
            ->count();


        $percentage = (int) floor(($finishedCount / $total) * 100);


        $enrollment->progress = $percentage;
        $enrollment->save();
    }


}
