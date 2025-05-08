<?php

use App\Models\Course;
use App\Models\Report;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\ActivityLog;
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

