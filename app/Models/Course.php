<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['faculty'];

    public static function generateCourseId(string $name){
        $id = strtoupper($name[0] . $name[1]);

        $key = 0;
        for($i = 0; $i <strlen($name); $i++){
            if($key == 1){
                $id .= strtoupper($name[$i] . $name[$i+1]);
                break;
            }

            if($name[$i] == ' '){
                $key = 1;
            }
        }

        if($key == 0){
            $id .= strtoupper($name[2] . $name[3]);
        }

        do{
            $courseId = $id . rand(10000, 99999);
        }while(Course::where('course_id', $courseId)->exists());

        return $courseId;
    }

    public function faculty(): BelongsTo{
        return $this->belongsTo(Faculty::class);
    }

    public function classrooms(): HasMany{
        return $this->hasMany(Classroom::class);
    }

    public function course_sessions(): HasMany{
        return $this->hasMany(CourseSession::class);
    }
}
