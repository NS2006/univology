<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScoreComponent extends Model
{
    protected $guarded = ['id'];

    protected $with = ['course'];

    public function course(): BelongsTo{
        return $this->belongsTo(Course::class);
    }

    public function student_scores(): HasMany{
        return $this->hasMany(StudentScore::class);
    }

    public static function createDummyComponent(Course $course){
        $weight_arr = [
            [30, 30, 40],
            [25, 35, 40],
            [20, 30, 50],
            [30, 35, 35],
            [15, 35, 50]
        ];

        $name_arr = [
            'Assignment', 'Mid Exam', 'Final Exam'
        ];

        $rand = rand(0, count($weight_arr) - 1);

        for($i = 0; $i < 3; $i++){
            ScoreComponent::create([
                'course_id' => $course->id,
                'name' => $name_arr[$i],
                'weight' => $weight_arr[$rand][$i],
            ]);
        }
    }
}
