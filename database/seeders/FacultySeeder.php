<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // template faculty
        Faculty::create([
            'name' => 'Computer Science'
        ]);

        Faculty::create([
            'name' => 'Information Systems'
        ]);

        Faculty::create([
            'name' => 'International Business Management'
        ]);

        Faculty::create([
            'name' => 'Finance'
        ]);

        Faculty::create([
            'name' => 'Marketing'
        ]);
    }
}
