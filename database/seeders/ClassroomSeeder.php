<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\StudentScore;
use Illuminate\Database\Seeder;
use App\Models\ClassroomSession;
use App\Models\MaterialProgress;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classroom = Classroom::create([
            'lecturer_id' => 1,
            'course_id' => 1,
            'class_code' => Classroom::generateClassCode(Faculty::where('id', '=', 1)->first()->name),
            'schedule' => 'Monday',
            'online_link' => ClassroomSession::getDummyOnlineLink()
        ]);

        $credit = $classroom->course->credit;

        $startDate = Carbon::today();
        $courseSessions = $classroom->course->course_sessions;
        for($i = 1; $i <= $credit * 6; $i++){
            $sessionDate = $startDate->copy()->addDays(($i - 1) * 7);
            ClassroomSession::create([
                'date' => $sessionDate,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'classroom_id' => $classroom->id,
                'course_session_id' => $courseSessions[$i-1]->id
            ]);
        }

        $students = Student::where('faculty_id', 1)->get();
        foreach($students as $student) {
            $enrollment = Enrollment::create([
                'student_id' => $student->id,
                'classroom_id' => $classroom->id,
                'coin' => rand(100, 999)
            ]);
            StudentScore::createDummyScore($enrollment);
            Enrollment::checkFinalScore($enrollment);

            foreach($courseSessions as $courseSession){
                foreach($courseSession->main_materials as $main_material){
                    MaterialProgress::create([
                        'enrollment_id' => $enrollment->id,
                        'material_id' => $main_material->material->id
                    ]);
                }
            }
        }
    }
}
