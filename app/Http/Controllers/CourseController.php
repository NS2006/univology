<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(){
        $user = Auth::user();

        if ($user->role->name == 'student') {
            $u = $user->student;

            $enrollments = $u->enrollments()
                ->when(request('search'), function($query) {
                    $query->where(function($q) {
                        $q->whereHas('classroom.course', function($q) {
                            $q->where('name', 'like', '%' . request('search') . '%');
                        })
                        ->orWhereHas('classroom', function($q) {
                            $q->where('class_code', 'like', '%' . request('search') . '%');
                        })
                        ->orWhereHas('classroom.lecturer.user', function($q) {
                            $q->where('name', 'like', '%' . request('search') . '%');
                        })
                        ->orWhereHas('classroom.lecturer', function($q) {
                            $q->where('lecturer_id', 'like', '%' . request('search') . '%');
                        });
                    });
                })->latest()->get();

            $classrooms = $enrollments->map(function($enrollment) {
                return $enrollment->classroom;
            });
        } else {
            $u = $user->lecturer;

            // Use query builder for filtering
            $classrooms = $u->classrooms()
                ->when(request('search'), function($query) {
                    $query->whereHas('course', function($q) {
                        $q->where('name', 'like', '%' . request('search') . '%');
                    })
                    ->orWhere('class_code', 'like', '%' . request('search') . '%');
                })->latest()->get();

            $enrollments = Enrollment::whereIn('classroom_id', $classrooms->pluck('id'))->orderBy('coin', 'DESC')->get();
        }

        return view('courses', [
            'title' => 'Univology | Courses',
            'enrollments' => $enrollments,
            'classrooms' => $classrooms
        ]);
    }
}
