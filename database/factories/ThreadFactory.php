<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentences(mt_rand(1, 6), true),
            'category_id' => mt_rand(1, 10),
            'content' => fake()->paragraphs(10, true),
            // 'content' => fake()->words(1, true),
        ];
    }
}
