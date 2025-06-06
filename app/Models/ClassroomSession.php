<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassroomSession extends Model
{
    protected $guarded = ["id"];

    protected $with = ['classroom', 'course_session'];

    protected $casts = [
        'date' => 'date'
    ];

    public function classroom(): BelongsTo{
        return $this->belongsTo(Classroom::class);
    }

    public function course_session(): BelongsTo{
        return $this->belongsTo(CourseSession::class);
    }

    public function additional_materials(): HasMany{
        return $this->hasMany(AdditionalMaterial::class);
    }

    public function attendances(): HasMany{
        return $this->hasMany(Attendance::class);
    }

    public static function getDummyOnlineLink(){
        return 'https://guthib.com/';
    }

    public static function getClassroomSessionById(Classroom $classroom, $classroom_session_id){
        $classroom_session = $classroom->classroom_sessions()
            ->where('classroom_session_id', $classroom_session_id)
            ->firstOrFail();

        return $classroom_session;
    }

    public static function isValidOnlineSession(ClassroomSession $classroom_session){
        $now = Carbon::now();

        // Combine the date and time into full datetime objects
        $class_start = Carbon::parse(date('Y-m-d', strtotime($classroom_session->date)) . ' ' . $classroom_session->start_time);
        $class_end = Carbon::parse(date('Y-m-d', strtotime($classroom_session->date)) . ' ' . $classroom_session->end_time);


        // Define the attendance window
        $start_window = $class_start->copy()->subMinutes(20);
        $end_window = $class_end->copy()->addMinutes(20);

        // Return true if current time is between the window
        return $now->between($start_window, $end_window);
    }

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->classroom_session_id = Str::uuid();
        });
    }
}
