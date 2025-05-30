<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\CourseSession;
use App\Models\ScoreComponent;
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

        $course_name = [
            'Software Engineering', 'Computer Networks', 'Algorithm and Programming', 'Web Programming', 'Data Sturtures'
        ];

        for($i = 0; $i < count($course_name); $i++){
            $course = Course::create([
                'name' => $course_name[$i],
                'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
                'credit' => 2,
                'faculty_id' => 1
            ]);
            CourseSession::createDummySession($course);
            ScoreComponent::createDummyComponent($course);
        }

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
                ScoreComponent::createDummyComponent($course);
            }
        }
    }
}
