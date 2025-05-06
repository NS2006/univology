<?php

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
    return view('login');
})->name('login')->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('user');

Route::get('/dashboard/admin', function () {
    return view('dashboard', [
        'faculties' => Faculty::all(),
        'students' => Student::all(),
        'lecturers' => Lecturer::all(),
        'logs' => ActivityLog::whereDate('created_at', now()->toDateString())->latest()->get(),
        'reports' => Report::where('status', false)->get(),
    ]);
})->name('dashboard_admin')->middleware('admin');

Route::post('/user/report', [MiscController::class,'reportUser']);

Route::post('/register/user', [AdminController::class,'registerUser']);

Route::post('/register/faculty', [AdminController::class,'registerFaculty']);

Route::post('/login', [LoginController::class,'authenticate']);

Route::post('/logout', [LoginController::class,'logout']);

