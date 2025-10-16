<?php

namespace Database\Factories;

use App\Models\Rubric;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rubric>
 */
class RubricFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parent = Rubric::inRandomOrder()->first();

        return [
            'title' => $this->faker->words(1, true),
            'parent_id' => $parent?->id,
        ];
    }
}
