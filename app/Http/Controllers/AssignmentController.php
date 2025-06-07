<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Question;
use App\Models\Classroom;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentEntry;
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
        $user = Auth::user();

        $student = $user->student;

        $classrooms = $student->enrollments->pluck('classroom');

        $assignments = Assignment::whereIn('classroom_id', $classrooms->pluck('id'))
            ->when(request('class'), function ($query, $id) {
                $query->where('classroom_id', $id);
            })
            ->latest()
            ->get();

        return view('assignments', [
            'title' => 'My Assignments',
            'classrooms' => $classrooms,
            'assignments' => $assignments
        ]);
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
            'assignments' => $assignments
        ]);
    }

    public function deleteAssignment(Assignment $assignment){
        $assignment->delete();

        return redirect('/assignments');
    }

    public function indexAssignment(Assignment $assignment){
        $deadline = $assignment->deadline ? Carbon::parse($assignment->deadline)->format('M d, Y') : 'No deadline';

        $deadline_passed = $assignment->deadline && Carbon::now()->gt($assignment->deadline) ? 'Deadline passed' : Carbon::parse($assignment->deadline)->diffForHumans();

        $classroom = $assignment->classroom;

        $classroom_code = $classroom->class_code;
        $course_name = $classroom->course->name;

        $started_at = $assignment->updated_at;
        $finished_at = $assignment->deadline;



        if(Auth::user()->role->name == 'student'){
            $enrollment = Auth::user()->student->enrollments->firstWhere('classroom_id', $assignment->classroom_id)->first();

            $assignment_entry = $enrollment->assignment_entries->where('assignment_id', $assignment->id)->first();

            if($assignment_entry){
                $is_finished = $assignment_entry->is_finished;
            } else{
                $is_finished = false;
            }
        } else{
            $is_finished = false;
        }

        return view('assignment', [
            'assignment' => $assignment,
            'deadline' => $deadline,
            'deadline_passed' => $deadline_passed,
            'classroom_code' => $classroom_code,
            'course_name' => $course_name,
            'started_at' => $started_at,
            'finished_at' => $finished_at,
            'is_finished' => $is_finished,
            'page' => 'home'
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

    public function submitAnswer(Assignment $assignment){
        $enrollment = Auth::user()->student->enrollments->firstWhere('classroom_id', $assignment->classroom_id)->first();

        $assignment_entry = $enrollment->assignment_entries->where('assignment_id', $assignment->id)->first();

        $student_choices = $assignment_entry->student_choices;

        $questions = $assignment->questions;
        $results = [];

        foreach ($questions as $question) {
            $student_choice = $student_choices->firstWhere('question_id', $question->id);
            $is_correct = $student_choice &&
                        $student_choice->choice_id == $question->correct_choice->choice_id;

            $results[] = [
                'question_id' => $question->id,
                'student_choice' => $student_choice ? $student_choice->choice_id : null,
                'correct_choice' => $question->correct_choice->choice_id,
                'is_correct' => $is_correct
            ];
        }

        $correct = collect($results)->where('is_correct', true)->count();
        $total = $questions->count();



        $enrollment->coin += Question::getCorrectCoin() * $total;
        $enrollment->save();

        $assignment_entry->is_finished = true;
        $assignment_entry->save();

        return redirect('/assignment/' . $assignment->assignment_id);
    }

    public function publishAssignment(Assignment $assignment, Request $request){
        $validated = $request->validate([
            'deadline_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (Carbon::parse($value)->isPast() && !Carbon::parse($value)->isToday()) {
                        $fail('The deadline date must be today or in the future.');
                    }
                },
            ],
            'deadline_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $deadlineDate = $request->input('deadline_date');
                    $deadlineDateTime = Carbon::createFromFormat('Y-m-d H:i', $deadlineDate . ' ' . $value);


                    if ($deadlineDateTime->isToday() && $deadlineDateTime->isPast()) {
                        $fail('For today\'s date, the deadline time must be in the future.');
                    }
                },
            ],
            'publish_confirm' => 'required|accepted'
        ]);



        $questionsWithoutCorrectAnswers = $assignment->questions()
            ->whereDoesntHave('correct_choice')
            ->count();

        if ($questionsWithoutCorrectAnswers > 0) {
            return redirect()->back()->with('error_choice', 'All questions must have a correct answer selected before publishing.')->withInput();
        }


        $deadline = Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['deadline_date'] . ' ' . $validated['deadline_time']
        );


        $assignment->update([
            'deadline' => $deadline,
            'is_published' => true
        ]);

        return redirect()->back();
    }
}
