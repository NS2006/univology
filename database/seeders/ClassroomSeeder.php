<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'schedule' => 'monday',
        ]);

        $students = Student::where('faculty_id', 1)->get();
        foreach($students as $student) {
            Enrollment::create([
                'student_id' => $student->id,
                'classroom_id' => $classroom->id,
                'coin' => rand(100, 999)
            ]);
        }
    }
}
