<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code'=> fake()->unique()->word(),
            'label' => fake()->word(),
            'internal_phone' => fake()->randomNumber(4, true),
            'external_phone'=> fake()->phoneNumber(),
            'email' => fake()->email()
        ];
    }
}
