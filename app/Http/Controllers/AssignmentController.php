<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function indexAssignments(){
        if(Auth::user()->lecturer){
            return $this->indexAssignmentsLecturer();
        } else{
            return $this->indexAssignmentsStudent();
        }
    }

    public function indexAssignmentsStudent(){

    }

    public function indexAssignmentsLecturer(){
        $user = Auth::user();

        $lecturer = $user->lecturer;
        $classrooms = $lecturer->classrooms;

        $assignments = Assignment::whereIn('classroom_id', $classrooms->pluck('id'))
            ->when(request('class'), function($query, $id) {
                $query->whereHas('classroom', fn($q) => $q->where('id', $id));
            })
            ->latest()->get();

        $unpublished_assignments = $assignments->where('is_published', false);

        return view('assignments', [
            'title' => 'My Assignments',
            'classrooms' => $classrooms,
            'unpublished_assignments' => $unpublished_assignments,
        ]);
    }

    public function deleteAssignment(Assignment $assignment){
        $assignment->delete();

        return redirect('/assignments');
    }

    public function indexAssignment(Assignment $assignment){
        return view('assignment', [
            'assignment' => $assignment
        ]);
    }

    public function newAssignment(Request $request){
        $classroom = Classroom::where('id', $request->classrooms[0])->first();

        $assignment = Assignment::create([
            'classroom_id' => $classroom->id,
            'title' => $request->title
        ]);

        return redirect('/assignment/' . $assignment->assignment_id);
    }
}
