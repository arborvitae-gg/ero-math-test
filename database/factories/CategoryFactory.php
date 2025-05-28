<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $min = $this->faker->numberBetween(3, 12);
        $max = $min + 1;
        return [
            'name' => $this->faker->unique()->word(),
            'min_grade' => $min,
            'max_grade' => $max,
        ];
    }
}
