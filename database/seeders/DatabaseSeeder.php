<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RoleSeeder::class, UserSeeder::class, FacultySeeder::class, StudentSeeder::class, LecturerSeeder::class, CourseSeeder::class]);

        Lecturer::factory(10)->recycle([
            Faculty::all()
        ])->create();

        Student::factory(50)->recycle([
            Faculty::all()
        ])->create();

        $this->call([ClassroomSeeder::class]);
    }
}
