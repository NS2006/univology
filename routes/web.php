<?php

use App\Models\Course;
use App\Models\Report;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

Route::get('/', function(){
    return view('login', ['title' => 'Univology | Login']);
})->name('login')->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Univology | Dashboard']);
})->name('dashboard')->middleware('user');

Route::get('/register', function () {
    return view('register', [
        'title' => 'Univology | Register',
        'faculties' => Faculty::all(),
        'students' => Student::all(),
        'lecturers' => Lecturer::all(),
        'courses' => Course::all()
    ]);
})->middleware('admin');

Route::prefix('register/classroom')->group(function () {
    // Show step
    Route::get('/{classroom_route}', function ($classroom_route) {
        $classroom_routes = [
            '1' => 'choose-faculty',
            '2' => 'choose-course',
            '3' => 'choose-lecturer',
            '4' => 'choose-student',
            '5' => 'confirmation'
        ];

        $step = 1; // Default step
        foreach($classroom_routes as $key => $route) {
            if($route == $classroom_route) {
                $step = $key;
                break;
            }
        }

        $canProceed = match($step) {
            1 => session()->has('registration.faculty'),
            2 => session()->has('registration.course'),
            3 => session()->has('registration.lecturer'),
            4 => session()->has('registration.student'),
            5 => true,
            default => false
        };

        $selectedFaculty = session()->get('registration.faculty');
        $selectedCourse = session()->get('registration.course');
        $selectedLecturer = session()->get('registration.lecturer');
        $selectedStudents = session()->get('registration.students');

        $courses = $selectedFaculty ? Course::where('faculty_id', $selectedFaculty->id)->get() : collect();
        $lecturers = $selectedFaculty ? Lecturer::where('faculty_id', $selectedFaculty->id)->get() : collect();
        $students = $selectedFaculty ? Student::where('faculty_id', $selectedFaculty->id)->get() : collect();

        if($step == 5){
            $classCode = Classroom::getClassCode($selectedFaculty);
        } else{
            $classCode = "DUMMY";
        }

        return view('register-classroom', [
            'title' => 'Univology | Register',
            'faculties' => Faculty::all(),
            'selectedFaculty' => $selectedFaculty,
            'selectedCourse' => $selectedCourse,
            'selectedLecturer' => $selectedLecturer,
            'selectedStudents' => $selectedStudents,
            'step' => (int)$step,
            'classroom_routes' => $classroom_routes,
            'courses' => $courses,
            'lecturers' => $lecturers,
            'students' => $students,
            'classCode' => $classCode,
            'canProceed' => $canProceed
        ]);
    })->middleware('admin')->name('register.classroom.classroom_route');

    // Store faculty selection
    Route::post('/store-data', function (Request $request) {
        if ($request->step == 4) {
            $request->validate([
                'student_ids' => 'required|array',
                'student_ids.*' => 'exists:students,id',
            ]);
            session()->put('registration.students', Student::find($request->student_ids));
        }

        if ($request->has('faculty_id')) {
            session()->put('registration.faculty', Faculty::find($request->faculty_id));
        }
        if ($request->has('course_id')) {
            session()->put('registration.course', Course::find($request->course_id));
        }
        if ($request->has('lecturer_id')) {
            session()->put('registration.lecturer', Lecturer::find($request->lecturer_id));
        }

        $classroom_routes = [
            '1' => 'choose-faculty',
            '2' => 'choose-course',
            '3' => 'choose-lecturer',
            '4' => 'choose-student',
            '5' => 'confirmation'
        ];

        $nextStep = $request->step + 1;

        if($nextStep == 6){
            $request->validate([
                'schedule' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            ]);

            $classroom = Classroom::create([
                'lecturer_id' => session()->get('registration.faculty')->id,
                'course_id' => session()->get('registration.course')->id,
                'class_code' => $request->classCode,
                'schedule' => $request->schedule,
            ]);

            $students = session()->get('registration.students');
            foreach($students as $student) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'classroom_id' => $classroom->id
                ]);
            }

            session()->forget('registration');

            return redirect()->route('register.classroom.classroom_route', [
                'course_route' => 'choose-faculty'
            ])->with('success', 'New Classroom has been created successfully!');
        }

        return redirect()->route('register.classroom.classroom_route', [
            'classroom_route' => $classroom_routes[$nextStep]
        ]);
    })->middleware('admin')->name('register.classroom.store-data');
});

Route::get('/dashboard/admin', function () {
    return view('dashboard', [
        'title' => 'Univology | Dashboard',
        'faculties' => Faculty::all(),
        'students' => Student::all(),
        'lecturers' => Lecturer::all(),
        'courses' => Course::all(),
        'logs' => ActivityLog::whereDate('created_at', now()->toDateString())->latest()->get(),
        'reports' => Report::where('status', false)->get(),
    ]);
})->name('dashboard_admin')->middleware('admin');

Route::post('/user/report', [MiscController::class,'reportUser']);

Route::post('/change/password', [MiscController::class,'changePassword']);

Route::post('/register/user', [AdminController::class,'registerUser']);

Route::post('/register/faculty', [AdminController::class,'registerFaculty']);

Route::post('/login', [LoginController::class,'authenticate']);

Route::post('/logout', [LoginController::class,'logout']);

