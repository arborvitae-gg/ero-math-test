<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Mark that DatabaseSeeder is running, so dependent seeders can check
        $this->wasRunFromDatabaseSeeder = true;
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            QuizSeeder::class,

        ]);
    }
}
