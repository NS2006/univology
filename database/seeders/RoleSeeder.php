<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        Role::create([
            "name"=> "student",
        ]);

        // 2
        Role::create([
            "name"=> "lecturer",
        ]);

        // 3
        Role::create([
            "name"=> "admin",
        ]);
    }
}
