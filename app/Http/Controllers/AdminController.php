<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
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
                'student_id' => 'STU' . rand(10000, 99999),
                'email' => Student::getEmail($validatedData['name']),
                'faculty_id' => (int)($validatedData['faculty'])
            ]);
        } else{
            $user->lecturer()->create([
                'lecturer_id' => 'LEC' . rand(10000, 99999),
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
}
