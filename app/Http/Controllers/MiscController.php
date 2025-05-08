<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return redirect('/dashboard')->with('success','Successfully create new report!')->with('keep_modal_open', true);;
    }
}
