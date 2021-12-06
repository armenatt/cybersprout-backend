<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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
            'parent_id' => Comment::select('id')->inRandomOrder()->first('id'),
            'author_id' => User::select('id')->inRandomOrder()->first('id'),
            'like_count' => random_int(1, 200),
            'dislike_count' => random_int(1, 50),
            'text' => $this->faker->text(280),
            'post_id' => Post::select('id')->inRandomOrder()->first('id'),
            'is_updated' => random_int(0, 1),
            'is_hidden' => random_int(0, 1),
        ];

    }
}
