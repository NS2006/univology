<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Classroom;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\Request;

class ViewAllController extends Controller
{
    public function indexViewCourses(){
        $query = Course::query();

        if(request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('course_id', 'like', '%' . $search . '%')
                ->orWhereHas('faculty', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $courses = $query->latest()->get();

        return view('view-all', [
            'title'=> 'Univology | View All',
            'header' => 'Courses',
            'courses' => $courses
        ]);
    }

    public function indexViewLecturers(){
       $query = Lecturer::query();

        if(request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('lecturer_id', 'like', '%' . $search . '%')
                ->orWhereHas('faculty', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $lecturers = $query->latest()->get();

        return view('view-all', [
            'title'=> 'Univology | View All',
            'header' => 'Lecturers',
            'lecturers' => $lecturers
        ]);
    }

    public function indexViewStudents(){
        $query = Student::query();

        if(request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('student_id', 'like', '%' . $search . '%')
                ->orWhereHas('faculty', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $students = $query->latest()->get();

        return view('view-all', [
            'title'=> 'Univology | View All',
            'header' => 'Students',
            'students' => $students
        ]);
    }

    public function indexViewFaculties(){
        $query = Faculty::query();

        if(request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $faculties = $query->latest()->get();

        return view('view-all', [
            'title'=> 'Univology | View All',
            'header' => 'Faculties',
            'faculties' => $faculties
        ]);
    }

    public function indexViewClassrooms(){
        $query = Classroom::query();

        if(request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('class_code', 'like', '%' . $search . '%')
                ->orWhereHas('course', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('course_id', 'like', '%' . $search . '%');
                })
                ->orWhereHas('lecturer.user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('lecturer', function($q) use ($search) {
                    $q->where('lecturer_id', 'like', '%' . $search . '%');
                });
            });
        }
        $classrooms = $query->latest()->get();

        return view('view-all', [
            'title'=> 'Univology | View All',
            'header' => 'Classrooms',
            'classrooms' => $classrooms
        ]);
    }
}
