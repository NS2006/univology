<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScoreBooster extends Model
{
    protected $guarded = ['id'];

    protected $with = ['student_score'];

    public function student_score(): BelongsTo{
        return $this->belongsTo(StudentScore::class);
    }

    public static function getBooster(){
        return
            [
                [
                    'id' => 1,
                    'name' => 'Assignment Booster',
                    'description' => 'Add 1 bonus point to your assignment score',
                    'price' => 200,
                    'point' => 1
                ],
                [
                    'id' => 2,
                    'name' => 'Mid Exam Booster',
                    'description' => 'Add 1 bonus point to your final exam score',
                    'price' => 300,
                    'point' => 1
                ],
                [
                    'id' => 3,
                    'name' => 'Final Exam Booster',
                    'description' => 'Add 1 bonus point to your final exam score',
                    'price' => 500,
                    'point' => 1
                ]
            ];
    }
}
