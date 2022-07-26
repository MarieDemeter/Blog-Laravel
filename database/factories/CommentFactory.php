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
        $user_id = null;
        $speudo = null;
        $email = null;

        if ($random > 0.5) {
            $user_id = User::inRandomOrder()->value('id');
        } else {
            $speudo = $this->faker->name();
            $email = $this->faker->email();
        }

        return [
            'content' => $this->faker->text(),
            'article_id' => Article::inRandomOrder()->value('id'),
            'user_id' => $user_id,
            'speudo' => $speudo,
            'email' => $email,
        ];
    }
}
