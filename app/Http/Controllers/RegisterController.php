<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\MainMaterial;
use Illuminate\Http\Request;
use App\Models\CourseSession;

class RegisterController extends Controller
{
    public function classroomStoreData (Request $request) {
        if ($request->step == 4) {
            $request->validate([
                'student_ids' => 'required|array',
                'student_ids.*' => 'exists:students,id',
            ]);
            session()->put('registration.classroom.students', Student::find($request->student_ids));
        }

        if ($request->has('faculty_id')) {
            session()->put('registration.classroom.faculty', Faculty::find($request->faculty_id));
        }
        if ($request->has('course_id')) {
            session()->put('registration.classroom.course', Course::find($request->course_id));
        }
        if ($request->has('lecturer_id')) {
            session()->put('registration.classroom.lecturer', Lecturer::find($request->lecturer_id));
        }

        $classroom_routes = [
            '1' => 'choose-faculty',
            '2' => 'choose-course',
            '3' => 'choose-lecturer',
            '4' => 'choose-student',
            '5' => 'confirmation'
        ];

        $nextStep = $request->step + 1;

        if($nextStep == 6){
            $request->validate([
                'schedule' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            ]);

            $classroom = Classroom::create([
                'lecturer_id' => session()->get('registration.classroom.lecturer')->id,
                'course_id' => session()->get('registration.classroom.course')->id,
                'class_code' => $request->classCode,
                'schedule' => $request->schedule,
            ]);

            $students = session()->get('registration.classroom.students');
            foreach($students as $student) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'classroom_id' => $classroom->id
                ]);
            }

            session()->forget('registration.classroom');

            return redirect()->route('register.classroom.classroom_route', [
                'classroom_route' => 'choose-faculty'
            ])->with('registration.classroom.success', 'New Classroom has been created successfully!');
        }

        return redirect()->route('register.classroom.classroom_route', [
            'classroom_route' => $classroom_routes[$nextStep]
        ]);
    }

    public function classroomRoute ($classroom_route) {
        $classroom_routes = [
            '1' => 'choose-faculty',
            '2' => 'choose-course',
            '3' => 'choose-lecturer',
            '4' => 'choose-student',
            '5' => 'confirmation'
        ];

        $step = 1; // Default step
        foreach($classroom_routes as $key => $route) {
            if($route == $classroom_route) {
                $step = $key;
                break;
            }
        }

        $canProceed = match($step) {
            1 => session()->has('registration.classroom.faculty'),
            2 => session()->has('registration.classroom.course'),
            3 => session()->has('registration.classroom.lecturer'),
            4 => session()->has('registration.classroom.student'),
            5 => true,
            default => false
        };

        $selectedFaculty = session()->get('registration.classroom.faculty');
        $selectedCourse = session()->get('registration.classroom.course');
        $selectedLecturer = session()->get('registration.classroom.lecturer');
        $selectedStudents = session()->get('registration.classroom.students');

        $courses = $selectedFaculty ? Course::where('faculty_id', $selectedFaculty->id)->get() : collect();
        $lecturers = $selectedFaculty ? Lecturer::where('faculty_id', $selectedFaculty->id)->get() : collect();
        $students = $selectedFaculty ? Student::where('faculty_id', $selectedFaculty->id)->get() : collect();

        if($step == 5){
            $classCode = Classroom::generateClassCode($selectedFaculty->name);
        } else{
            $classCode = "DUMMY";
        }

        return view('register-classroom', [
            'title' => 'Univology | Register',
            'faculties' => Faculty::all(),
            'selectedFaculty' => $selectedFaculty,
            'selectedCourse' => $selectedCourse,
            'selectedLecturer' => $selectedLecturer,
            'selectedStudents' => $selectedStudents,
            'step' => (int)$step,
            'classroom_routes' => $classroom_routes,
            'courses' => $courses,
            'lecturers' => $lecturers,
            'students' => $students,
            'classCode' => $classCode,
            'canProceed' => $canProceed
        ]);
    }

    public function courseStoreData (Request $request) {
        if ($request->step == 2) {
            $request->validate([
                'course_name' => 'required|min:2',
            ]);
        }

        if ($request->has('faculty_id')) {
            session()->put('registration.course.faculty', Faculty::find($request->faculty_id));
        }

        if ($request->has('course_id')) {
            session()->put('registration.course.course_id', $request->get('course_id'));
        }

        if ($request->has('course_name')) {
            session()->put('registration.course.course_name', $request->get('course_name'));
        }

        if ($request->has('course_credit')) {
            session()->put('registration.course.course_credit', $request->get('course_credit'));
        }

        if ($request->has('fill_session')) {
            session()->put('registration.course.fill_session', $request->get('fill_session')); // on || null
        }

        if($request->step == 3){
            $sessions = [];

            for ($i = 1; $i <= session()->get('registration.course.course_credit') * 6; $i++) {
                $sessions[] = [
                    'title' => $request->get("course_session_{$i}_title"),
                    'main_material' => $request->get("course_session_{$i}_main_material")
                ];
            }

            session()->put('registration.course.sessions', $sessions);
        }

        $course_routes = [
            '1' => 'choose-faculty',
            '2' => 'course-information',
            '3' => 'session-information',
            '4' => 'confirmation'
        ];

        $nextStep = $request->step + 1;

        if($nextStep == 5){
            $course = Course::create([
                'course_id' => session()->get('registration.course.course_id'),
                'name' => session()->get('registration.course.course_name'),
                'credit' => session()->get('registration.course.course_credit'),
                'faculty_id' => session()->get('registration.course.faculty')->id,
            ]);

            $sessions = session()->get('registration.course.sessions');

            for($curr = 1; $curr <= $course->credit * 6; $curr++){
                $session = CourseSession::create([
                    'session_number' => $curr,
                    'title' => $sessions[$curr-1]['title'],
                    'course_id' => $course->id
                ]);

                MainMaterial::create([
                    'link' => $sessions[$curr-1]['main_material'],
                    'course_session_id' => $session->id
                ]);
            }

            session()->forget('registration.course');

            return redirect()->route('register.course.course_route', [
                'course_route' => 'choose-faculty'
            ])->with('registration.course.success', 'New Course has been created successfully!');
        }

        return redirect()->route('register.course.course_route', [
            'course_route' => $course_routes[$nextStep]
        ]);
    }

    public function courseRoute ($course_route) {
        $course_routes = [
            '1' => 'choose-faculty',
            '2' => 'course-information',
            '3' => 'session-information',
            '4' => 'confirmation'
        ];

        $step = 1; // Default step
        foreach($course_routes as $key => $route) {
            if($route == $course_route) {
                $step = $key;
                break;
            }
        }

        if($step <= 2){
            session()->forget('registration.course.fill_session');
            session()->forget('registration.course.sessions');
        }

        $totalSession = session()->get('registration.course.course_credit') * 6;
        $courseName = session()->get('registration.course.course_name');
        $courseCredit = session()->get('registration.course.course_credit');
        $sessions = session()->get('registration.course.sessions');
        $selectedFaculty = session()->get('registration.course.faculty');

        if($step == 2){
            $courseId = Course::generatecourseId($selectedFaculty->name);
        } else if($step == 4){
            $courseId = session()->get('registration.course.course_id');
        } else{
            $courseId = "";
        }

        if($step == 3 && session()->has("registration.course.fill_session")) {
            $sessionTitle = "Dango Daikazoku";
            $sessionMaterialLink = "https://www.youtube.com/watch?v=rFKKSQ8GgHk";
        } else{
            $sessionTitle = "";
            $sessionMaterialLink = "";
        }

        $canProceed = match($step) {
            1 => session()->has('registration.course.faculty'),
            default => false
        };

        return view('register-course', [
            'title' => 'Univology | Register',
            'faculties' => Faculty::all(),
            'selectedFaculty' => $selectedFaculty,
            'step' => (int)$step,
            'course_routes' => $course_routes,
            'courseId' => $courseId,
            'courseName' => $courseName,
            'courseCredit' => $courseCredit,
            'totalSession' => $totalSession,
            'sessionMaterialLink' => $sessionMaterialLink,
            'sessionTitle' => $sessionTitle,
            'sessions' => $sessions,
            'canProceed' => $canProceed
        ]);
    }
}
