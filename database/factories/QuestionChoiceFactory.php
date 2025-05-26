<?php
namespace Database\Factories;

use App\Models\QuestionChoice;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionChoiceFactory extends Factory
{
    protected $model = QuestionChoice::class;

    public function definition()
    {
        return [
            'question_id' => Question::factory(),
            'choice_text' => $this->faker->word,
            'choice_image' => null,
            'is_correct' => false,
        ];
    }
}
