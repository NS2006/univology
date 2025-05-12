<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Faculty;
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

        Course::create([
            'name' => 'Software Engineering',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'faculty_id' => 1
        ]);

        Course::create([
            'name' => 'Computer Networks',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'faculty_id' => 1
        ]);

        Course::create([
            'name' => 'Algorithm and Programming',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'faculty_id' => 1
        ]);

        Course::create([
            'name' => 'Data Structures',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'faculty_id' => 1
        ]);

        Course::create([
            'name' => 'Web Programming',
            'course_id' => Course::generateCourseId($faculties->where('id', '==', 1)->first()->name),
            'faculty_id' => 1
        ]);

        for( $j = 2; $j < 5; $j++ ) {
            for($i = 0; $i < 2; $i++) {
                $name = 'Dummy Course ' . $i . $j;
                Course::create([
                    'name' => $name,
                    'course_id' => Course::generateCourseId($faculties->where('id', '==', $j)->first()->name),
                    'faculty_id' => $j
                ]);
            }
        }
    }
}
