<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecturer>
 */
class LecturerFactory extends Factory
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
            "role_id" => 2
        ]);

        return [
            'lecturer_id' => 'LEC' . rand(10000, 99999),
            'email' => Lecturer::getEmail($name),
            'faculty_id' => Faculty::inRandomOrder()->first()->id,
            'user_id' => $user->id
        ];
    }
}
