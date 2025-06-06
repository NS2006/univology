<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $guarded = ['id'];

    protected $with = ['classroom_session', 'enrollment'];

    public function classroom_session(): BelongsTo{
        return $this->belongsTo(ClassroomSession::class);
    }

    public function enrollment(): BelongsTo{
        return $this->belongsTo(Enrollment::class);
    }

    public static function canAttendance(ClassroomSession $classroom_session){
        $now = Carbon::now();
        $class_start = Carbon::parse($classroom_session->start_time);

        $start_window = $class_start->copy()->subMinutes(20);
        $end_window = $class_start->copy()->addMinutes(20);

        return $now->between($start_window, $end_window);
    }
}
