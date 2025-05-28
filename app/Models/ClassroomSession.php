<?php

namespace App\Models;

use Illuminate\Support\Str;
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

    public static function getDummyOnlineLink(){
        return 'https://guthib.com/';
    }

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->classroom_session_id = Str::uuid();
        });
    }
}
