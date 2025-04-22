<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Level 1', 'min_grade' => 3, 'max_grade' => 4],
            ['name' => 'Level 2', 'min_grade' => 5, 'max_grade' => 6],
            ['name' => 'Level 3', 'min_grade' => 7, 'max_grade' => 8],
            ['name' => 'Level 4', 'min_grade' => 9, 'max_grade' => 10],
            ['name' => 'Level 5', 'min_grade' => 11, 'max_grade' => 12],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
