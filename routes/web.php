<?php

use App\Models\Course;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Classroom;
use App\Models\CourseSession;
use App\Models\ClassroomSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/', function(){
    return view('login', ['title' => 'Univology | Login']);
})->name('login')->middleware('guest');

Route::get('/dashboard', [DashboardController::class, 'indexUser'])->name('dashboard')->middleware('user');

Route::get('/register', function () {
    return view('register', [
        'title' => 'Univology | Register',
        'faculties' => Faculty::all(),
        'students' => Student::all(),
        'lecturers' => Lecturer::all(),
        'courses' => Course::all()
    ]);
})->middleware('admin');

Route::get('/courses', [CourseController::class, 'index'])->middleware('user');

Route::prefix('/classroom/{classroom:class_id}')->group(function () {
    Route::get('/session/{course_session:session_id}', function(Classroom $classroom, ClassroomSession $classroomSession){
        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'classroomSession' => $classroomSession
        ]);
    });
})->middleware('user');

Route::middleware(['clear.registration'])->group(function () {
    Route::prefix('register/classroom')->group(function () {
        // Show step
        Route::get('/{classroom_route}', [RegisterController::class, 'classroomRoute'])->middleware('admin')->name('register.classroom.classroom_route');

        // Store data selection
        Route::post('/store-data', [RegisterController::class, 'classroomStoreData'])->middleware('admin')->name('register.classroom.store-data');
    });

    Route::prefix('register/course')->group(function () {
        // Show step
        Route::get('/{course_route}', [RegisterController::class, 'courseRoute'])->middleware('admin')->name('register.course.course_route');

        // Store data selection
        Route::post('/store-data', [RegisterController::class, 'courseStoreData'])->middleware('admin')->name('register.course.store-data');
    });
})->middleware('admin');


Route::get('/dashboard/admin', [DashboardController::class, 'indexAdmin'])->name('dashboard_admin')->middleware('admin');

Route::post('/user/report', [MiscController::class,'reportUser']);

Route::post('/change/password', [MiscController::class,'changePassword']);

Route::post('/register/user', [AdminController::class,'registerUser']);

Route::post('/register/faculty', [AdminController::class,'registerFaculty']);

Route::post('/solve/report', [AdminController::class,'solveReport']);

Route::post('/login', [LoginController::class,'authenticate']);

Route::post('/logout', [LoginController::class,'logout']);

