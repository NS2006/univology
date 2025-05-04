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
            'student_id' => 'STU' . rand(10000, 99999),
            'email' => Student::getEmail($name),
            'faculty_id' => Faculty::inRandomOrder()->first()->id,
            'user_id' => $user->id
        ]);
    }
}
