<?php

use App\Models\Course;
use App\Models\Report;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Enrollment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', function(){
    return view('login', ['title' => 'Univology | Login']);
})->name('login')->middleware('guest');

Route::get('/dashboard', function () {
    $user = Auth::user();

    $students = null;

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
    Route::get('/{classroom_route}', [RegisterController::class, 'classroomRoute'])->middleware('admin')->name('register.classroom.classroom_route');

    // Store faculty selection
    Route::post('/store-data', [RegisterController::class, 'classroomStoreData'])->middleware('admin')->name('register.classroom.store-data');
});

Route::get('/dashboard/admin', function () {
    return view('dashboard', [
        'title' => 'Univology | Dashboard',
        'faculties' => Faculty::all(),
        'students' => Student::all(),
        'lecturers' => Lecturer::all(),
        'courses' => Course::all(),
        'logs' => ActivityLog::whereDate('created_at', now()->toDateString())->latest()->get(),
        'reports' => Report::orderByRaw('status ASC')->latest()->get(),
    ]);
})->name('dashboard_admin')->middleware('admin');

Route::post('/user/report', [MiscController::class,'reportUser']);

Route::post('/change/password', [MiscController::class,'changePassword']);

Route::post('/register/user', [AdminController::class,'registerUser']);

Route::post('/register/faculty', [AdminController::class,'registerFaculty']);

Route::post('/solve/report', [AdminController::class,'solveReport']);

Route::post('/login', [LoginController::class,'authenticate']);

Route::post('/logout', [LoginController::class,'logout']);

