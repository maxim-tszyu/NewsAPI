<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\News;
use App\Models\Rubric;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'announcement' => $this->faker->paragraph(),
            'text' => $this->faker->paragraph(),
            'publish_date' => $this->faker->dateTime(),
            'author_id' => Author::all()->random()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($news) {
            $rubrics = Rubric::inRandomOrder()->take(rand(1, 3))->get();
            $news->rubrics()->sync($rubrics);
        });
    }
}
