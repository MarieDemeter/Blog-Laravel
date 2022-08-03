<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCommentAPITest extends TestCase
{
    use RefreshDatabase;

    public function test_the_api_comment_return_json_file_with_correct_data()
    {
        Article::factory(100)->forUser()->create();
        Comment::factory(50)->create();
        //$this->seed(DatabaseSeeder::class);

        $article = Article::latest()->first();

        $response = $this->postJson('/api/comment', [
            'article_id' => $article->id,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('article_id', $article->id);
        $response->assertJsonPath('content', 'bla bla bla');
        $response->assertJsonPath('pseudo', 'test');
        $response->assertJsonPath('email', 'test@test.fr');
    }

    public function test_the_api_comment_send_data_to_bdd()
    {
        Article::factory(100)->forUser()->create();
        Comment::factory(50)->create();
        //$this->seed(DatabaseSeeder::class);

        $article = Article::latest()->first();

        $response = $this->postJson('/api/comments', [
            'article_id' => $article->id,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);
    }

    public function test_the_api_comment_validation_fail_for_wrong_email()
    {
        $article = Article::factory()->forUser()->create();
        $comment = Comment::factory()->make([
            'user_id' => null,
            'pseudo' => fake()->name(),
            'email' => fake()->email(),
        ]);

        $response = $this->postJson('/api/comments', [
            'article_id' => $article->id,
            'content' => $comment->content,
            'pseudo' => $comment->pseudo,
            'email' => 'noagoodemail',
        ]);

        $response->assertStatus(422)
        ->assertInvalid(['email']);
    }

    public function test_the_api_comment_validation_fail_for_invalid_id()
    {
        Article::factory(100)->forUser()->create();
        Comment::factory(50)->create();
        //$this->seed(DatabaseSeeder::class);

        $response = $this->postJson('/api/comments', [
            'article_id' => 1,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);
        $response->assertStatus(422);
    }
}
