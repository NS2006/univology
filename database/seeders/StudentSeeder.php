<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = "dummy";

        $user = User::create([
            "name"=> $name,
            "password" => bcrypt("dummy"),
            "role_id" => 1
        ]);

        Student::create([
            'student_id' => Student::generateStudentId(),
            'email' => Student::getEmail($name),
            'faculty_id' => 1,
            'user_id' => $user->id
        ]);

        for($i = 1; $i <= 10; $i++){
            $name = "dummy" . $i;

            $user = User::create([
                "name"=> $name,
                "password" => bcrypt("dummy"),
                "role_id" => 1
            ]);

            Student::create([
                'student_id' => Student::generateStudentId(),
                'email' => Student::getEmail($name),
                'faculty_id' => 1,
                'user_id' => $user->id
            ]);
        }
    }
}
