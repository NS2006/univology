<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecturer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['faculty', 'user'];

    public static function generateLecturerId(){
        do{
            $lecturerId = 'LEC' . rand(10000, 99999);
        }while(Lecturer::where('lecturer_id', $lecturerId)->count() > 0);

        return $lecturerId;
    }

    public static function getEmail($name): string{
        return User::getEmailName($name) . '@uni.edu';
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function faculty(): BelongsTo{
        return $this->belongsTo(Faculty::class);
    }

    public function classrooms(): HasMany{
        return $this->hasMany(Classroom::class);
    }
}
