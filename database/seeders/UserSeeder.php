<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Normal user
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            // 'role' => 'user',
            'grade_level' => 3,
            'school' => 'Sample Elementary School',
            'coach_name' => 'Ms. Smith',
        ]);

        // Normal user
        User::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            // 'role' => 'user',
            'grade_level' => 4,
            'school' => 'Better Sample Elementary School',
            'coach_name' => 'Mrs. Smith',
        ]);
    }
}
