<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();

        $user = User::create([
            "name"=> $name,
            "password" => bcrypt(User::getDefaultPassword($name)),
            "role_id" => 1
        ]);

        return [
            'student_id' => Student::generateStudentId(),
            'email' => Student::getEmail($name),
            'faculty_id' => Faculty::inRandomOrder()->first()->id,
            'user_id' => $user->id
        ];
    }
}
