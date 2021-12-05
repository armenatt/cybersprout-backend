<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => Comment::all()->random()->id,
            'author_id' => random_int(1, 330),
            'like_count' => random_int(1, 200),
            'dislike_count' => random_int(1, 50),
            'text' => $this->faker->text(280),
            'post_id' => random_int(3, 1000),
            'is_updated' => random_int(0, 1),
            'is_hidden' => random_int(0, 1),
        ];

    }
}
