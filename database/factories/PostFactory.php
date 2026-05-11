<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title'  => $this->faker->sentence(),
            'body'   => $this->faker->paragraph(3, true),
            'published_at' => null,
        ];
    }
        public function published(): static
        {
            return $this->state(fn (array $attributes) => [
                    'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }
}
