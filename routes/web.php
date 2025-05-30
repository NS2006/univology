<?php

use App\Models\Classroom;
use App\Models\ClassroomSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ViewAllController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;

Route::get('/', function(){
    return view('login', ['title' => 'Univology | Login']);
})->name('login')->middleware('guest');

Route::get('/dashboard', [DashboardController::class, 'indexUser'])->name('dashboard')->middleware('user');

Route::get('/administration', [AdminController::class, 'indexAdministration'])->middleware('admin');

Route::prefix('/view-all')->group(function(){
    Route::get('/courses', [ViewAllController::class, 'indexViewCourses'])->middleware('admin');

    Route::get('/lecturers', [ViewAllController::class, 'indexViewLecturers'])->middleware('admin');

    Route::get('/students', [ViewAllController::class, 'indexViewStudents'])->middleware('admin');

    Route::get('/faculties', [ViewAllController::class, 'indexViewFaculties'])->middleware('admin');

    Route::get('/classrooms', [ViewAllController::class, 'indexViewClassrooms'])->middleware('admin');
});

Route::get('/courses', [CourseController::class, 'index'])->middleware('user');

Route::prefix('/classroom/{classroom:class_id}')->scopeBindings()->group(function () {
    Route::get('/session/{classroom_session}', [ClassroomController::class, 'indexSession']);

    Route::get('/about', [ClassroomController::class, 'indexAbout']);

    Route::get('/view-score', [ClassroomController::class, 'indexViewScore'])->middleware('student');

    Route::prefix('/submit-score')->scopeBindings()->group(function () {
        Route::get('/', [ClassroomController::class, 'indexSubmitScore']);

        Route::get('/{submission_name}', [ClassroomController::class, 'submissionPage']);

        Route::post('/{submission_name}/submit', [ClassroomController::class, 'doScoreSubmission']);
    })->middleware('lecturer');

    Route::get('/score-statistics', [ClassroomController::class, 'indexScoreStatistics'])->middleware('lecturer');

    Route::post('/session/{classroom_session}/add-material', [ClassroomController::class, 'addAdditionalMaterial']);

    Route::post('/view-material', [ClassroomController::class, 'viewMaterial']);
})->middleware('user');

Route::middleware(['clear.registration'])->group(function () {
    Route::prefix('register/classroom')->scopeBindings()->group(function () {
        Route::get('/{classroom_route}', [RegisterController::class, 'classroomRoute'])->name('register.classroom.classroom_route');

        Route::post('/store-data', [RegisterController::class, 'classroomStoreData'])->name('register.classroom.store-data');
    });

    Route::prefix('register/course')->scopeBindings()->group(function () {
        Route::get('/{course_route}', [RegisterController::class, 'courseRoute'])->name('register.course.course_route');

        Route::post('/store-data', [RegisterController::class, 'courseStoreData'])->name('register.course.store-data');
    });

    Route::prefix('register/user')->scopeBindings()->group(function () {
        Route::get('/{user_route}', [RegisterController::class, 'userRoute'])->name('register.user.user_route');

        Route::post('/store-data', [RegisterController::class, 'userStoreData'])->name('register.user.store-data');
    });

    Route::prefix('register/faculty')->scopeBindings()->group(function () {
        Route::get('/{faculty_route}', [RegisterController::class, 'facultyRoute'])->name('register.faculty.faculty_route');

        Route::post('/store-data', [RegisterController::class, 'facultyStoreData'])->name('register.faculty.store-data');
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

