<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Quiz;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionChoice;
use Database\Seeders\QuizSeederHelper;

class QuizSeeder extends Seeder
{
    use QuizSeederHelper;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedQuiz('test 5');
        $this->seedQuiz('test 6');
        $this->seedQuiz('test 7');
        // change the quiz name
    }
}
