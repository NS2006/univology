<?php

use App\Models\Classroom;
use App\Models\ClassroomSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ViewAllController;

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
        Route::get('/{classroom_route}', [RegisterController::class, 'classroomRoute'])->middleware('admin')->name('register.classroom.classroom_route');

        Route::post('/store-data', [RegisterController::class, 'classroomStoreData'])->middleware('admin')->name('register.classroom.store-data');
    });

    Route::prefix('register/course')->group(function () {
        Route::get('/{course_route}', [RegisterController::class, 'courseRoute'])->middleware('admin')->name('register.course.course_route');

        Route::post('/store-data', [RegisterController::class, 'courseStoreData'])->middleware('admin')->name('register.course.store-data');
    });

    Route::prefix('register/user')->group(function () {
        Route::get('/{user_route}', [RegisterController::class, 'userRoute'])->middleware('admin')->name('register.user.user_route');

        Route::post('/store-data', [RegisterController::class, 'userStoreData'])->middleware('admin')->name('register.user.store-data');
    });

    Route::prefix('register/faculty')->group(function () {
        Route::get('/{faculty_route}', [RegisterController::class, 'facultyRoute'])->middleware('admin')->name('register.faculty.faculty_route');

        Route::post('/store-data', [RegisterController::class, 'facultyStoreData'])->middleware('admin')->name('register.faculty.store-data');
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

