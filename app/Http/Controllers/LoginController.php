<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(Request $request){
        if($request['email'] !== "admin"){
            $credentials = $request->validate([
                "email"=> [
                    "required",
                    "email:dns",
                    "ends_with:@uni.ac.id,@uni.edu"
                ],
                "password" => 'required'
            ]);
        } else{
            $credentials = $request;
        }


        // auth / login process

        $student = Student::where('email', $credentials['email'])->first();
        $lecturer = Lecturer::where('email', $credentials['email'])->first();
        $admin = User::where('name', $credentials['email'])->first();

        if($student){
            $user = $student->user;
        } elseif($lecturer){
            $user = $lecturer->user;
        } elseif($admin){
            $user = $admin;
        } else{
            $user = null;
        }

        if($user  && Hash::check($credentials['password'], $user->password)){
            Auth::login($user);
            $request->session()->regenerate();

            if($user->role->name == 'admin'){
                return redirect()->intended('/dashboard/admin');
            } else{
                ActivityLog::create([
                    'type' => 'logged in',
                    'user_id' => $user->id
                ]);


                return redirect()->intended('/dashboard');
            }
        }

        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request){
        $user = Auth::user();

        if($user->role->name != 'admin'){
            ActivityLog::create([
                'type' => 'logged out',
                'user_id' => $user->id
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
