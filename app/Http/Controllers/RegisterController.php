<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\MainMaterial;
use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Models\AdminHistoryLog;
use App\Models\ClassroomSession;
use App\Models\MainMaterialProgress;

class RegisterController extends Controller
{
    public function facultyStoreData (Request $request) {
        $faculty_routes = [
            '1' => 'faculty-information',
        ];

        $nextStep = $request->step + 1;

        if($nextStep == 2){
            $faculty = Faculty::create([
                'name' => $request->faculty_name
            ]);

            AdminHistoryLog::createHistory('New Faculty called ' . $faculty->name . ' has been created successfully');

            return redirect()->route('register.faculty.faculty_route', [
                'faculty_route' => 'faculty-information'
            ])->with('registration.faculty.success', 'New Faculty has been created successfully!');
        }

        return redirect()->route('register.faculty.faculty_route', [
            'faculty_route' => $faculty_routes[$nextStep]
        ]);
    }

    public function facultyRoute ($faculty_route) {
        $faculty_routes = [
            '1' => 'faculty-information',
        ];

        $step = 1; // Default step
        foreach($faculty_routes as $key => $route) {
            if($route == $faculty_route) {
                $step = $key;
                break;
            }
        }

        return view('register-faculty', [
            'title' => 'Univology | Register',
            'step' => (int)$step,
            'faculty_routes' => $faculty_routes
        ]);
    }

    public function userStoreData (Request $request) {
        if ($request->step == 2) {
            $request->validate([
                'role' => 'required|in:student,lecturer',
            ]);
            session()->put('registration.user.role', $request->role);
            session()->put('registration.user.user_name', $request->user_name);
        }

        if ($request->has('faculty_id')) {
            session()->put('registration.user.faculty', Faculty::find($request->faculty_id));
        }

        $user_routes = [
            '1' => 'choose-faculty',
            '2' => 'user-information',
            '3' => 'confirmation'
        ];

        $nextStep = $request->step + 1;

        if($nextStep == 4){
            $user_name = session('registration.user.user_name');
            $role_id = session('registration.user.role') == 'student' ? 1 : 2;

            $user = User::create([
                'name'=> $user_name,
                'password' => bcrypt(User::getDefaultPassword($user_name)),
                'role_id'=> $role_id
            ]);

            // Student n Lecturer

            if($role_id == 1){
                $user->student()->create([
                    'student_id' => $request->user_id,
                    'email' => Student::getEmail($user_name),
                    'faculty_id' => session('registration.user.faculty')->id
                ]);

                AdminHistoryLog::createHistory('New Student named ' . $user->name . ' - ' . $user->student->student_id . ' has been created successfully');
            } else{
                $user->lecturer()->create([
                    'lecturer_id' => Lecturer::generateLecturerId(),
                    'email' => Lecturer::getEmail($user_name),
                    'faculty_id' => session('registration.user.faculty')->id
                ]);

                AdminHistoryLog::createHistory('New Lecturer named ' . $user->name . ' - ' . $user->lecturer->lecturer_id . ' has been created successfully');
            }

            session()->forget('registration.user');

            return redirect()->route('register.user.user_route', [
                'user_route' => 'choose-faculty'
            ])->with('registration.user.success', 'New User has been created successfully!');
        }

        return redirect()->route('register.user.user_route', [
            'user_route' => $user_routes[$nextStep]
        ]);
    }

    public function userRoute ($user_route) {
        $user_routes = [
            '1' => 'choose-faculty',
            '2' => 'user-information',
            '3' => 'confirmation'
        ];

        $step = 1; // Default step
        foreach($user_routes as $key => $route) {
            if($route == $user_route) {
                $step = $key;
                break;
            }
        }

        $faculties = Faculty::all();

        $canProceed = match($step) {
            1 => session()->has('registration.classroom.faculty'),
            default => true
        };


        $role = session()->get('registration.user.role');
        $user_name = session()->get('registration.user.user_name');
        $selectedFaculty = session()->get('registration.user.faculty');
        $user_id = "";
        $email_name  = "";
        $default_password = "";


        if($step == 3){
            if($role == 'student'){
                $user_id = Student::generateStudentId();
                $email_name = Student::getEmail($user_name);
            } else{
                $user_id = Lecturer::generateLecturerId();
                $email_name = Lecturer::getEmail($user_name);
            }
            $default_password = User::getDefaultPassword($user_name);
        }

        return view('register-user', [
            'title' => 'Univology | Register',
            'step' => (int)$step,
            'user_routes' => $user_routes,
            'canProceed' => $canProceed,
            'faculties' => $faculties,
            'selectedFaculty' => $selectedFaculty,
            'role' => $role,
            'user_name' => $user_name,
            'user_id' => $user_id,
            'email_name' => $email_name,
            'default_password' => $default_password
        ]);
    }

    public function classroomStoreData (Request $request) {
        if ($request->step == 4) {
            $request->validate([
                'student_ids' => 'required|array',
                'student_ids.*' => 'exists:students,id',
            ]);
            session()->put('registration.classroom.students', Student::find($request->student_ids));
        }

        if ($request->step == 5) {
            $date = $request->date;
            $startTime = Carbon::createFromFormat('H:i', $request->start_time);
            $endTime = $startTime->copy()->addHours(2);

            session()->put('registration.classroom.information', [
                'start_time' => $startTime->format('H:i'),
                'end_time' => $endTime->format('H:i'),
                'date' => $date
            ]);

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
            '5' => 'classroom-information',
            '6' => 'confirmation'
        ];

        $nextStep = $request->step + 1;

        if($nextStep == 7){
            $classroomInformation = session()->get('registration.classroom.information');
            $date = Carbon::parse($classroomInformation['date']);
            $dayName = $date->format('l');

            $classroom = Classroom::create([
                'lecturer_id' => session()->get('registration.classroom.lecturer')->id,
                'course_id' => session()->get('registration.classroom.course')->id,
                'class_code' => $request->classCode,
                'schedule' => $dayName,
            ]);

            $credit = session()->get('registration.classroom.course')->credit;


            $startDate = Carbon::parse($classroomInformation['date']);
            $courseSessions = session()->get('registration.classroom.course')->course_sessions;
            for($i = 1; $i <= $credit * 6; $i++){
                $sessionDate = $startDate->copy()->addDays(($i - 1) * 7);
                ClassroomSession::create([
                    'date' => $sessionDate,
                    'start_time' => $classroomInformation['start_time'],
                    'end_time' => $classroomInformation['end_time'],
                    'classroom_id' => $classroom->id,
                    'course_session_id' => $courseSessions[$i-1]->id
                ]);
            }

            $students = session()->get('registration.classroom.students');
            foreach($students as $student) {
                $enrollment = Enrollment::create([
                    'student_id' => $student->id,
                    'classroom_id' => $classroom->id
                ]);

                foreach($classroom->course->course_sessions as $course_session){
                    foreach($course_session->main_materials as $main_material){
                        MainMaterialProgress::create([
                            'enrollment_id' => $enrollment->id,
                            'main_material_id' => $main_material->id
                        ]);
                    }
                }
            }


            AdminHistoryLog::createHistory('New Classroom ' . $classroom->class_code . ' - ' . $classroom->course->name . ' by ' . $classroom->lecturer->lecturer_id . ' - ' . $classroom->lecturer->user->name . ' has been created successfully');

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
            '5' => 'classroom-information',
            '6' => 'confirmation'
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
            5 => session()->has('registration.classroom.information'),
            6 => true,
            default => false
        };

        $selectedFaculty = session()->get('registration.classroom.faculty');
        $selectedCourse = session()->get('registration.classroom.course');
        $selectedLecturer = session()->get('registration.classroom.lecturer');
        $selectedStudents = session()->get('registration.classroom.students');
        $classroomInformation = session()->get('registration.classroom.information');

        $courses = $selectedFaculty ? Course::where('faculty_id', $selectedFaculty->id)->get() : collect();
        $lecturers = $selectedFaculty ? Lecturer::where('faculty_id', $selectedFaculty->id)->get() : collect();
        $students = $selectedFaculty ? Student::where('faculty_id', $selectedFaculty->id)->get() : collect();

        if($step == 6){
            $classCode = Classroom::generateClassCode($selectedFaculty->name);
        } else{
            $classCode = "";
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
            'canProceed' => $canProceed,
            'classroomInformation' => $classroomInformation
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

            AdminHistoryLog::createHistory('New Course ' . $course->course_id . ' - ' . $course->name . ' from Faculty ' . $course->faculty->name . ' has been created successfully');

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
            $sessionTitle = CourseSession::getDummyTitle();
            $sessionMaterialLink = MainMaterial::getDummyLink();
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
