<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomSession extends Model
{
    protected $guarded = ["id"];

    protected $with = ['classroom', 'course_session'];

    public function classroom(): BelongsTo{
        return $this->belongsTo(Classroom::class);
    }

    public function course_session(): BelongsTo{
        return $this->belongsTo(CourseSession::class);
    }
}
