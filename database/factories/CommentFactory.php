<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $random = rand(0, 1);
        $arr = [
            'content' => $this->faker->text(),
            'article_id' => Article::inRandomOrder()->first(),
        ];

        if ($random > 0.5) {
            $arr['user_id'] = User::inRandomOrder()->first();
        } else {
            $arr['pseudo'] = $this->faker->name();
            $arr['email'] = $this->faker->email();
        }

        return $arr;
    }
}
