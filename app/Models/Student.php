<?php

namespace App\Models;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['faculty', 'user'];

    public static function generateStudentId(){
        do{
            $studentId = 'STU' . rand(10000, 99999);
        }while(Student::where('student_id', $studentId)->count() > 0);

        return $studentId;
    }

    public static function getEmail($name): string{
        return User::getEmailName($name) . '@uni.ac.id';
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function faculty(): BelongsTo{
        return $this->belongsTo(Faculty::class);
    }

    public function enrollments(): HasMany{
        return $this->hasMany(Enrollment::class);
    }
}
