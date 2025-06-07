<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Report;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Enrollment;
use App\Models\ActivityLog;
use App\Models\AdminHistoryLog;
use App\Models\ClassroomSession;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexUser(){
        $user = Auth::user();
        $now = Carbon::now();

        if ($user->role->name == 'student') {
            $u = $user->student;
            $enrollments = $u->enrollments;
            $classrooms = $enrollments->map(function($enrollment) {
                return $enrollment->classroom;
            });

            $topSession = ClassroomSession::with(['classroom.enrollments' => function($query) use ($u){
                    $query->where('student_id', $u->id);
                }])
                ->whereIn('classroom_id', $classrooms->pluck('id'))
                ->where('is_finished', 0)
                ->where(function ($query) use ($now) {
                    $query->where('date', '>', $now->toDateString())
                        ->orWhere(function ($query) use ($now) {
                            $query->whereDate('date', $now->toDateString())
                                    ->whereTime('start_time', '>', $now->toTimeString());
                        })->orWhere(function ($query) use ($now) {
                            $query->whereDate('date', $now->toDateString())
                                    ->whereTime('end_time', '>', $now->toTimeString());
                        });
                })
                ->orderBy('date', 'ASC')
                ->orderBy('start_time', 'ASC')
                ->first();


            $assignments = $classrooms->pluck('assignments')->flatten()->where('is_published', true);
        } else {
            $u = $user->lecturer;
            $classrooms = $u->classrooms;
            $enrollments = Enrollment::whereIn('classroom_id', $classrooms->pluck('id'))
                ->orderBy('coin', 'DESC')
                ->get();

            $topSession = ClassroomSession::whereIn('classroom_id', $classrooms->pluck('id'))
                ->where('is_finished', 0)
                ->where(function ($query) use ($now) {
                    $query->where('date', '>', $now->toDateString())
                        ->orWhere(function ($query) use ($now) {
                            $query->whereDate('date', $now->toDateString())
                                    ->whereTime('start_time', '>', $now->toTimeString());
                        })
                        ->orWhere(function ($query) use ($now) {
                            $query->whereDate('date', $now->toDateString())
                                    ->whereTime('end_time', '>', $now->toTimeString());
                        });
                })
                ->orderBy('date', 'ASC')
                ->orderBy('start_time', 'ASC')
                ->first();


            $assignments = $classrooms->pluck('assignments')->flatten();
        }

        return view('dashboard', [
            'title' => 'Univology | Dashboard',
            'classrooms' => $classrooms,
            'enrollments' => $enrollments,
            'topSession' => $topSession,
            'assignments' => $assignments,
        ]);
    }

    public function indexAdmin () {
        return view('dashboard', [
            'title' => 'Univology | Dashboard',
            'faculties' => Faculty::all(),
            'students' => Student::all(),
            'lecturers' => Lecturer::all(),
            'courses' => Course::all(),
            'logs' => ActivityLog::whereDate('created_at', now()->toDateString())->latest()->get(),
            'reports' => Report::orderByRaw('status ASC')->latest()->get(),
            'histories' => AdminHistoryLog::orderByRaw('created_at DESC')->latest()->get(),
        ]);
    }
}
