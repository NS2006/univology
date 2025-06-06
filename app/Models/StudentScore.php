<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentScore extends Model
{
    protected $guarded = ['id'];

    protected $with = ['score_component', 'enrollment'];

    public function score_component(): BelongsTo{
        return $this->belongsTo(ScoreComponent::class);
    }

    public function enrollment(): BelongsTo{
        return $this->belongsTo(Enrollment::class);
    }

    public function score_booster(): HasOne{
        return $this->hasOne(ScoreBooster::class);
    }

    public static function createDummyScore(Enrollment $enrollment){
        $score_components = ScoreComponent::where('course_id', $enrollment->classroom->course->id)->get();


        $rand = rand(0, 3);

        for($i = 0; $i < count($score_components); $i++){
            StudentScore::create([
                'enrollment_id' => $enrollment->id,
                'score_component_id' => $score_components[$i]->id,
                'score' => $rand >= 1 ? rand(0, 100) : null
            ]);
        }
    }
}
