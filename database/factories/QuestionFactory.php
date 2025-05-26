<?php
namespace Database\Factories;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'quiz_id' => Quiz::factory(),
            'category_id' => Category::factory(),
            'question_text' => $this->faker->sentence,
            'question_image' => null,
        ];
    }
}
