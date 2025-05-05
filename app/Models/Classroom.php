<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Enrollment;
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
}
