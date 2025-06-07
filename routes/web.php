<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ViewAllController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssignmentController;

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

Route::get('/assignments', [AssignmentController::class, 'indexAssignments'])->middleware('user');

Route::prefix('/assignment')->scopeBindings()->group(function(){
    Route::prefix('/{assignment:assignment_id}')->scopeBindings()->group(function(){
        Route::get('/', [AssignmentController::class, 'indexAssignment']);

        Route::get('/question', [QuestionController::class, 'directQuestion'])->middleware('lecturer');

        Route::get('/do-question', [QuestionController::class, 'doQuestion'])->middleware('student');

        Route::get('/question/new-question', [QuestionController::class, 'addNewQuestion']);

        Route::prefix('/question/{question:question_id}')->scopeBindings()->group(function(){
            Route::get('/', [QuestionController::class, 'indexQuestion']);

            Route::post('/save-question', [QuestionController::class, 'saveQuestion']);

            Route::post('/save-choice', [QuestionController::class, 'saveChoice']);

            Route::post('/delete', [QuestionController::class, 'deleteQuestion']);
        })->middleware('lecturer');

        Route::post('/submit-answer', [AssignmentController::class, 'submitAnswer'])->middleware('student');

        Route::post('/delete-assignment', [AssignmentController::class, 'deleteAssignment'])->middleware('lecturer');

        Route::post('/publish', [AssignmentController::class, 'publishAssignment'])->middleware('lecturer');
    })->middleware('user');

    Route::post('/new-assignment', [AssignmentController::class, 'newAssignment'])->middleware('lecturer');
})->middleware('user');

Route::prefix('/classroom/{classroom:class_id}')->scopeBindings()->group(function () {
    Route::prefix('/session/{classroom_session}')->scopeBindings()->group(function(){
        Route::get('/', [ClassroomController::class, 'indexSession']);

        Route::get('/attendance', [ClassroomController::class, 'indexAttendance'])->middleware('lecturer');

        Route::get('/online-link', [ClassroomController::class, 'directOnlineLink']);

        Route::post('/attendance/save-attendance', [ClassroomController::class, 'saveAttendance']);
    });

    Route::get('/about', [ClassroomController::class, 'indexAbout']);

    Route::get('/view-score', [ClassroomController::class, 'indexViewScore'])->middleware('student');

    Route::get('/shop', [ClassroomController::class, 'indexShop'])->middleware('student');

    Route::prefix('/submit-score')->scopeBindings()->group(function () {
        Route::get('/', [ClassroomController::class, 'indexSubmitScore']);

        Route::get('/{submission_name}', [ClassroomController::class, 'submissionPage']);

        Route::post('/{submission_name}/submit', [ClassroomController::class, 'doScoreSubmission']);
    })->middleware('lecturer');

    Route::get('/score-statistics', [ClassroomController::class, 'indexScoreStatistics'])->middleware('lecturer');

    Route::post('/shop/{booster_id}', [ClassroomController::class, 'purchaseBooster'])->middleware('student');

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
