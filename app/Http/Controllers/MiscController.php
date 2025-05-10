<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MiscController extends Controller
{
    public function reportUser(Request $request){
        $validatedData = $request->validate([
            'description' => 'required',
        ]);

        $user = Auth::user();

        Report::create([
            'description' => $validatedData['description'],
            'user_id' => $user->id
        ]);

        return redirect('/dashboard')->with('success-report','Successfully create new report!');
    }

    public function changePassword(Request $request){
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8'
        ]);

        $user = Auth::user();

        if($user && Hash::check($request['oldPassword'], $user->password)){
            User::where('id', $user->id)->update([
                'password' => Hash::make($request['newPassword'])
            ]);

            return back()->with('success-change-password','Successfully change the password!')->with('keep_modal_open', true);
        }

        return back()->with('error-change-password','Failed to change the password!')->with('keep_modal_open', true);
    }
}
