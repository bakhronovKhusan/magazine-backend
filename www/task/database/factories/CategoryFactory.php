<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'parent_id' => 0,
            'has_child' => '1',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            if ($category->has_child) {
                Category::factory()
                    ->count(3)
                    ->create([
                        'parent_id' => $category->id,
                        'has_child' => '0',
                    ]);
            }
        });
    }
}

