<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Report;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class AdminController extends Controller
{
    public function registerUser(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'role' => 'required|not_in:placeholder',
            'faculty' => 'required|not_in:placeholder'
        ]);


        //User
        $role_id = $validatedData['role'] == 'student' ? 1 : 2;

        $user = User::create([
            'name'=> $validatedData['name'],
            'password' => bcrypt(User::getDefaultPassword($validatedData['name'])),
            'role_id'=> $role_id
        ]);

        // Student n Lecturer

        if($validatedData['role'] == 'student'){
            $user->student()->create([
                'student_id' => Student::generateStudentId(),
                'email' => Student::getEmail($validatedData['name']),
                'faculty_id' => (int)($validatedData['faculty'])
            ]);
        } else{
            $user->lecturer()->create([
                'lecturer_id' => Lecturer::generateLecturerId(),
                'email' => Lecturer::getEmail($validatedData['name']),
                'faculty_id' => (int)($validatedData['faculty'])
            ]);
        }

        return redirect('/dashboard/admin')->with('success','User Registration successful!');
    }

    public function registerFaculty(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        Faculty::create([
            'name' => $validatedData['name'],
        ]);

        return redirect('/dashboard/admin')->with('success','Faculty Registration successful!');
    }

    public function solveReport(Request $request){
        $report =  Report::where('id', $request->report_id)->first();
        Report::where('id', $request->report_id)->update([
            'status' => $report->status ? false : true
        ]);

        return redirect('/dashboard/admin')->with([
            'success-solve-report' => true,
            'report-id' => $report->id
        ]);
    }

    public function indexAdministration () {
        return view('administration', [
            'title' => 'Univology | Administration',
            'faculties' => Faculty::all(),
            'students' => Student::all(),
            'lecturers' => Lecturer::all(),
            'courses' => Course::all(),
            'classrooms' => Classroom::all()
        ]);
    }
}
