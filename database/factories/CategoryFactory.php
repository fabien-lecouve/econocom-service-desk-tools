<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'parent_id' => null,
            'font_color_id' => null, 
            'background_color_id' => null, 
            'border_top_color_id' => null, 
            'code'=> fake()->unique()->word(),
            'label' => fake()->word(),
            'position' => fake()->numberBetween(1, 100)
        ];
    }
}
