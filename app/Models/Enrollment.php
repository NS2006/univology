<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['student', 'classroom'];

    public function final_grade(){
        if($this->final_score == null){
            return null;
        }

        $grade = [
            ['90', 'A+',],
            ['85', 'A',],
            ['80', 'A-',],
            ['70', 'B',],
            ['60', 'C',],
            ['50', 'D',],
            ['40', 'E',],
            ['0', 'F']
        ];

        for($i = 0; $i < count($grade); $i++){
            if($this->final_score >= $grade[$i][0]){
                return $grade[$i][1];
            }
        }
    }

    public function student(): BelongsTo{
        return $this->belongsTo(Student::class);
    }

    public function classroom(): BelongsTo{
        return $this->belongsTo(Classroom::class);
    }

    public function student_scores(): HasMany{
        return $this->hasMany(StudentScore::class);
    }

    public function purchase_histories(): HasMany{
        return $this->hasMany(PurchaseHistory::class);
    }

    public function attendances(): HasMany{
        return $this->hasMany(Attendance::class);
    }

    public function assignment_entries(): HasMany{
        return $this->hasMany(AssignmentEntry::class);
    }

    public static function checkFinalScore(Enrollment $enrollment){
        $scores = $enrollment->student_scores;
        $final_score = 0;

        for($i = 0; $i < count($scores); $i++){
            if($scores[$i]->score == null){
                return;
            }
            $final_score += $scores[$i]->score * $scores[$i]->score_component->weight;
        }

        $enrollment->final_score = $final_score / 100;
        $enrollment->save();
    }

    public function getAttendanceForSession($sessionId){
        return $this->attendances()->where('classroom_session_id', $sessionId)->first();
    }
}
