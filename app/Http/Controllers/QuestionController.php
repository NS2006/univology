<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\CorrectChoice;
use App\Models\StudentChoice;
use App\Models\AssignmentEntry;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function directQuestion(Assignment $assignment){
        $questions = $assignment->questions;

        if($questions->count() == 0){
            $question = Question::create([
                'assignment_id' => $assignment->id
            ]);
        } else{
            $question = $questions->first();
        }

        return redirect('/assignment/' . $assignment->assignment_id . '/question/' . $question->question_id);
    }

    public function doQuestion(Assignment $assignment){
        $enrollment = Auth::user()->student->enrollments->firstWhere('classroom_id', $assignment->classroom_id);

        AssignmentEntry::updateOrCreate(
            [
                'enrollment_id' => $enrollment->id,
                'assignment_id' => $assignment->id,
            ],
            [
                'is_finished' => false,
            ]
        );

        $question = $assignment->questions->first();

        return redirect('/assignment/' . $assignment->assignment_id . '/question/' . $question->question_id);
    }

    public function indexQuestion(Assignment $assignment, Question $question){
        $all_questions = $assignment->questions;

        $selected_choice_id = -1;
        if(Auth::user()->role->name == 'student'){
            $enrollment = Auth::user()->student->enrollments->firstWhere('classroom_id', $assignment->classroom_id);

            $assignment_entry = $assignment->assignment_entries->firstWhere('enrollment_id', $enrollment->id);

            $selected_choice_id = $assignment_entry->student_choices->firstWhere('question_id', $question->id)->choice->id ?? -1;
        }

        return view('question', [
            'assignment' => $assignment,
            'question' => $question,
            'all_questions' => $all_questions,
            'selected_choice_id' => $selected_choice_id
        ]);
    }

    public function saveQuestion(Assignment $assignment, Question $question, Request $request){
        // Validate the request
        $validated = $request->validate([
            'question_text' => 'required|string',
            'correct_choice' => 'required',
            'choices.*.text' => 'sometimes|required|string',
            'new_choices.*.text' => 'sometimes|required|string',
        ]);

        // Update question text
        $question->question_text = $validated['question_text'];
        $question->save();

        $correctChoiceId = null;

        // Process existing choices
        if ($request->has('choices')) {
            foreach ($request->choices as $choiceId => $choiceData) {
                $choice = Choice::find($choiceId);

                if ($choiceData['action'] === 'delete') {
                    $choice->delete();
                } else {
                    $choice->description = $choiceData['text'];
                    $choice->save();

                    // Check if this is the correct choice
                    if ($request->correct_choice == $choiceId) {
                        $correctChoiceId = $choiceId;
                    }
                }
            }
        }

        // Process new choices
        if ($request->has('new_choices')) {
            foreach ($request->new_choices as $tempId => $newChoiceData) {
                if ($newChoiceData['action'] === 'create') {
                    $choice = Choice::create([
                        'question_id' => $question->id,
                        'description' => $newChoiceData['text']
                    ]);

                    // Check if this is the correct choice
                    if ($request->correct_choice === 'new_'.$tempId) {
                        $correctChoiceId = $choice->id;
                    }
                }
            }
        }

        // Update correct choice
        if($question->correct_choice){
            $question->correct_choice->delete(); // Remove previous correct choice
        }

        if ($correctChoiceId) {
            if($question->correct_choice){
                $question->correct_choice->create([
                    'question_id' => $question->id,
                    'choice_id' => $correctChoiceId
                ]);
            } else{
                CorrectChoice::create([
                    'choice_id' => $correctChoiceId,
                    'question_id' => $question->id
                ]);
            }
        }

        return redirect()->back()->with('success', 'Question saved successfully');
    }

    public function saveChoice (Assignment $assignment, Question $question, Request $request){
        $enrollment = Auth::user()->student->enrollments->firstWhere('classroom_id', $assignment->classroom_id);

        $assignment_entry = $assignment->assignment_entries->firstWhere('enrollment_id', $enrollment->id);

        StudentChoice::updateOrCreate(
            [
                'question_id' => $question->id,
                'assignment_entry_id' => $assignment_entry->id,
            ],
            [
                'choice_id' => $request->choice_id,
            ]
        );

        return redirect()->back();
    }

    public function addNewQuestion(Assignment $assignment){
        $question = Question::create([
            'assignment_id' => $assignment->id
        ]);

        return redirect('/assignment/' . $assignment->assignment_id . '/question/' . $question->question_id);
    }

    public function deleteQuestion(Assignment $assignment, Question $question){
        $question->delete();

        $questions = $assignment->questions;

        if($questions->count() == 0){
            return redirect('/assignment/' . $assignment->assignment_id);
        } else{
            return redirect('/assignment/' . $assignment->assignment_id . '/question/' . $questions->first()->question_id);
        }
    }
}
