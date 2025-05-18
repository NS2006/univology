<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Report;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Enrollment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexUser () {
        $user = Auth::user();

        if($user->role->name == 'student'){
            $u = $user->student;
            $enrollments = $u->enrollments;
            $classrooms = $enrollments->map(function($enrollment) {
                return $enrollment->classroom;
            });
        } else{
            $u = $user->lecturer;
            $classrooms = $u->classrooms;
            $enrollments = Enrollment::whereIn('classroom_id', $classrooms->pluck('id'))->orderBy('coin', 'DESC')->get();
        }

        return view('dashboard', [
            'title' => 'Univology | Dashboard',
            'classrooms' => $classrooms,
            'enrollments' => $enrollments
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
        ]);
    }
}
