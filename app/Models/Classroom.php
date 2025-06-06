<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['course', 'lecturer'];

    public function course(): BelongsTo{
        return $this->belongsTo(Course::class);
    }

    public function lecturer(): BelongsTo{
        return $this->belongsTo(lecturer::class);
    }

    public function enrollments(): HasMany{
        return $this->hasMany(Enrollment::class);
    }

    public function classroom_sessions(): HasMany{
        return $this->hasMany(ClassroomSession::class);
    }

    public function assignments(): HasMany{
        return $this->hasMany(Assignment::class);
    }

    public static function generateClassCode(string $name): string{
        $classCode = $name[0];

        $key = 0;
        for($i = 0; $i < strlen($name); $i++){
            if($key == 1){
                $classCode .= strtoupper($name[$i]);
                break;
            }

            if($name[$i] == ' '){
                $key = 1;
            }
        }

        if($key == 0){
            $classCode .= strtoupper($name[1]);
        }

        while(true){
            $numCode = rand(10, 99);

            $get = Classroom::where('class_code', ($classCode . $numCode))->get();

            if($get->isEmpty()){
                break;
            }
        }

        return str($classCode . $numCode);
    }

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->class_id = Str::uuid();
        });
    }
}
