<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = rtrim($this->faker->sentence(random_int(6, 12)), '.');
        $paragraphs = $this->faker->paragraphs(random_int(6, 10));
        $content = collect($paragraphs)->map(fn ($p) => "<p>{$p}</p>")->implode('');

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'excerpt' => $this->faker->sentence(20),
            'content' => $content,
            'featured_image' => 'https://picsum.photos/seed/'.$this->faker->unique()->numberBetween(1, 100000).'/1200/800',
            'status' => 'published',
            'is_featured' => false,
            'is_breaking' => false,
            'views_count' => $this->faker->numberBetween(10, 5000),
            'published_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'meta_title' => $title,
            'meta_description' => $this->faker->sentence(15),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    public function breaking(): static
    {
        return $this->state(fn () => ['is_breaking' => true]);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => 'draft', 'published_at' => null]);
    }
}
