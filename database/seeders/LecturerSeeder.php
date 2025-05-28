<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Lecturer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LecturerSeeder extends Seeder
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
            "role_id" => 2
        ]);

        Lecturer::create([
            'lecturer_id' => 'LEC' . rand(10000, max: 99999),
            'email' => Lecturer::getEmail($name),
            'faculty_id' => 1,
            'user_id' => $user->id
        ]);
    }
}
