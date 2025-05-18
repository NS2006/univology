<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\CourseSession;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = Faculty::all();

        $course = Course::create([
            'name' => 'Software Engineering',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'credit' => 2,
            'faculty_id' => 1
        ]);
        CourseSession::createDummySession($course);


        $course = Course::create([
            'name' => 'Computer Networks',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'credit' => 2,
            'faculty_id' => 1
        ]);
        CourseSession::createDummySession($course);


        $course = Course::create([
            'name' => 'Algorithm and Programming',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'credit' => 2,
            'faculty_id' => 1
        ]);
        CourseSession::createDummySession($course);


        $course = Course::create([
            'name' => 'Data Structures',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'credit' => 2,
            'faculty_id' => 1
        ]);
        CourseSession::createDummySession($course);


        $course = Course::create([
            'name' => 'Web Programming',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'credit' => 2,
            'faculty_id' => 1
        ]);
        CourseSession::createDummySession($course);


        for( $j = 2; $j < 5; $j++ ) {
            for($i = 0; $i < 2; $i++) {
                $name = 'Dummy Course ' . $i . $j;
                $course = Course::create([
                    'name' => $name,
                    'course_id' => Course::generateCourseId($faculties->where('id', '==', $j)->first()->name),
                    'credit' => 2,
                    'faculty_id' => $j
                ]);
                CourseSession::createDummySession($course);

            }
        }
    }
}
