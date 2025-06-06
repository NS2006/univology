<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Material;
use App\Models\Classroom;
use App\Models\Attendance;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use App\Models\ScoreBooster;
use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use App\Models\ClassroomSession;
use App\Models\MaterialProgress;
use App\Models\AdditionalMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function indexSession(Classroom $classroom, $classroom_session_id) {
        $classroom_session = ClassroomSession::getClassroomSessionById($classroom, $classroom_session_id);

        $valid_session = ClassroomSession::isValidOnlineSession($classroom_session);

        session()->put('classroom.current.session', '/classroom/' . $classroom->class_id . '/session/' . $classroom_session->classroom_session_id);

        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'classroom_session' => $classroom_session,
            'valid_session' => $valid_session,
            'page' => 'session'
        ]);
    }

    public function indexAbout(Classroom $classroom) {
        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'page' => 'about'
        ]);
    }

    public function indexShop(Classroom $classroom) {
        $student = Auth::user()->student;

        $enrollment = $classroom->enrollments->where('student_id', $student->id)->first();
        $boosters = ScoreBooster::getBooster();

        $purchase_histories = PurchaseHistory::where('enrollment_id', $enrollment->id)->get();

        $total_sessions = $enrollment->attendances->count();
        $attendance = $enrollment->attendances->where('status', true)->count();

        $attendance_percentage = ($attendance / $total_sessions) * 100;

        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'enrollment' => $enrollment,
            'boosters' => $boosters,
            'purchase_histories' => $purchase_histories,
            'attendance_percentage' => $attendance_percentage,
            'page' => 'shop'
        ]);
    }

    public function indexSubmitScore(Classroom $classroom) {
        $score_components = $classroom->course->score_components;

        if(session()->has('classroom.current.submit')) {
            session()->forget('classroom.current.submit');
        }

        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'page' => 'submit_score',
            'submission' => false,
            'score_components' => $score_components,
        ]);
    }

    public function indexAttendance(Classroom $classroom, $classroom_session_id){
        $classroom_session = ClassroomSession::getClassroomSessionById($classroom, $classroom_session_id);

        $enrollments = $classroom->enrollments;
        $attendances = $classroom_session->attendances;

        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'classroom_session' => $classroom_session,
            'enrollments' => $enrollments,
            'attendances' => $attendances,
            'page' => 'attendance'
        ]);
    }

    public function indexScoreStatistics(Classroom $classroom) {
        $enrollments = $classroom->enrollments;
        $score_components = $classroom->course->score_components;

        // Calculate statistics
        $average_score = $enrollments->avg('final_score');
        $highest_score = $enrollments->max('final_score');
        $lowest_score = $enrollments->min('final_score');

        $passed_students = $enrollments->filter(fn($e) => $e->final_score >= 50)->count();
        $pass_rate = round(($passed_students / $enrollments->count()) * 100, 2);

        $top_student = $enrollments->sortByDesc('final_score')->first()->student->user;
        $bottom_student = $enrollments->sortBy('final_score')->first()->student->user;

        // Calculate component averages
        $component_averages = [];
        foreach ($score_components as $component) {
            $component_averages[$component->id] = round($enrollments->flatMap->student_scores
                ->where('score_component_id', $component->id)
                ->avg('score'), 2);
        }

        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'page' => 'score_statistics',
            'enrollments' => $enrollments,
            'score_components' => $score_components,
            'average_score' => round($average_score, 2),
            'highest_score' => round($highest_score, 2),
            'lowest_score' => round($lowest_score, 2),
            'pass_rate' => $pass_rate,
            'passed_students' => $passed_students,
            'total_students' => $enrollments->count(),
            'top_student' => $top_student,
            'bottom_student' => $bottom_student,
            'component_averages' => $component_averages
        ]);
    }

    public function indexViewScore(Classroom $classroom) {
        $user = Auth::user();

        $enrollment = $classroom->enrollments->where('student_id', $user->student->id)->first();

        $user_scores = $enrollment->student_scores;

        Enrollment::checkFinalScore($enrollment);

        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'page' => 'view_score',
            'user_scores' => $user_scores,
            'enrollment' => $enrollment
        ]);
    }

    public function submissionPage(Classroom $classroom, $slug_component) {
        $score_components = $classroom->course->score_components;

        $score_component = $score_components->first(function ($component) use ($slug_component) {
            return Str::slug($component->name) === $slug_component;
        });

        $enrollments = $classroom->enrollments->sortBy(function ($enrollment) {
            return $enrollment->student->student_id;
        });

        session()->put('classroom.current.submit', url()->current());

        return view('classroom', [
            'title' => $classroom->class_code . ' ' . $classroom->course->name,
            'classroom' => $classroom,
            'page' => 'submit_score',
            'submission' => true,
            'score_components' => $score_components,
            'enrollments' => $enrollments,
            'score_component' => $score_component
        ]);
    }

    public function doScoreSubmission(Classroom $classroom, $slug_component, Request $request){
        // Find the score component
        $score_components = $classroom->course->score_components;
        $score_component = $score_components->first(function ($component) use ($slug_component) {
            return Str::slug($component->name) === $slug_component;
        });

        // Validate request data
        $request->validate([
            'scores.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // Process each submitted score
        foreach ($request->input('scores', []) as $enrollmentId => $score) {
            $enrollment = $classroom->enrollments->find($enrollmentId);

            $student_score = $enrollment->student_scores->first(function ($score) use ($score_component) {
                return $score->score_component_id === $score_component->id;
            });



            if ($score != null && $student_score->score == null) {
                $student_score->score = $score;

                $score_booster = $student_score->score_booster;
                if($score_booster != null){
                    $student_score->score += $student_score->score != 100 ? $score_booster->bonus : 0;
                }


                $student_score->save();

                Enrollment::checkFinalScore($enrollment);
            }
        }

        return redirect(session()->get('classroom.current.submit'))->with('success', 'Scores updated successfully');
    }

    public function addAdditionalMaterial(Classroom $classroom, $classroom_session_id, Request $request) {
        $classroom_session = ClassroomSession::getClassroomSessionById($classroom, $classroom_session_id);

        $material = Material::create([
            'link' => $request->material_link,
            'topic' => $request->material_topic
        ]);

        AdditionalMaterial::create([
            'material_id' => $material->id,
            'classroom_session_id' => $classroom_session->id
        ]);

        foreach($classroom->enrollments as $enrollment) {
            MaterialProgress::create([
                'enrollment_id' => $enrollment->id,
                'material_id' => $material->id
            ]);

            MaterialProgress::calculateProgress($enrollment, $classroom);
        }

        return redirect(session()->get('classroom.current.session'));
    }

    public function purchaseBooster(Classroom $classroom, $booster_id ,Request $request){
        $boosters = ScoreBooster::getBooster();
        $booster = $boosters[$booster_id - 1];

        $booster_name = Str::slug(str_replace('Booster', '', $booster['name']));

        $enrollment = Enrollment::where('id', $request->enrollment_id)->first();
        $student_scores = $enrollment->student_scores;

        $student_score = $student_scores->first(function ($score) use ($booster_name) {
            $component_slug = Str::slug($score->score_component->name);
            return $component_slug === $booster_name;
        });

        PurchaseHistory::create([
            'enrollment_id' => $enrollment->id,
            'description' => 'Buy ' . $booster['name'] . ' with ' . $booster['price'] . ' coins'
        ]);

        ScoreBooster::updateOrCreate(
            ['student_score_id' => $student_score->id],
            ['bonus' => DB::raw('bonus + 1')]
        );

        if($student_score->score != null){
            $student_score->score += $student_score->score != 100 ? 1 : 0;

            $student_score->save();
        }

        $enrollment->coin -= $booster['price'];
        $enrollment->save();

        return redirect('/classroom/' . $classroom->class_id . '/shop');
    }

    public function viewMaterial(Classroom $classroom, Request $request) {
        $user = Auth::user();

        if($user->role->name == 'student'){
            $enrollment = $classroom->enrollments->where('student_id', $user->student->id)->first();

            MaterialProgress::updateOrCreate(
                [
                    'material_id' => $request->material_id,
                    'enrollment_id' => $enrollment->id,
                    'status' => true
                ]
            );

            MaterialProgress::calculateProgress($enrollment, $classroom);
        }

        return redirect()->away($request->redirect_url);
    }

    public function directOnlineLink(Classroom $classroom, $classroom_session_id){
        $user = Auth::user();

        $classroom_session = ClassroomSession::getClassroomSessionById($classroom, $classroom_session_id);
        if($user->role->name == 'student'){
            $enrollments = $classroom->enrollments;
            $enrollment = $enrollments->where('student_id', $user->student->id)->first();

            if (Attendance::canAttendance($classroom_session)) {
                Attendance::updateOrCreate(
                    [
                        'enrollment_id' => $enrollment->id,
                        'classroom_session_id' => $classroom_session->id,
                    ],
                    [
                        'status' => true,
                    ]
                );
            }
        }

        return redirect()->away($classroom->online_link);
    }

    public function saveAttendance(Classroom $classroom, $classroom_session_id, Request $request){
        $classroom_session = ClassroomSession::getClassroomSessionById($classroom, $classroom_session_id);
        $attendance_data = $request->input('attendance', []);

        foreach ($attendance_data as $enrollment_id => $status) {
            $status = $status === 'present' ? true : false;

            Attendance::updateOrCreate(
                ['enrollment_id' => $enrollment_id, 'classroom_session_id' => $classroom_session->id],
                ['status' => $status]
            );
        }

        ClassroomSession::updateOrCreate(
            ['id' => $classroom_session->id],
            ['is_finished' => 1]
        );

        return redirect()->back()->with('success', 'Attendance saved!');
    }
}
