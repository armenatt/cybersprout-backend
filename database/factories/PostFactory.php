<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => $this->faker->numberBetween(1, 100),
            'title' => $this->faker->title,
            'source_link' => $this->faker->slug(),
            'is_updated' => random_int(0, 1),
            'view_count' => random_int(1, 10000),
            'type' => 1,
            'game' => 1,
            'text' => $this->faker->text(100000),
            'like_count' => random_int(1, 500),
            'dislike_count' => random_int(1, 500)
        ];
    }
}
