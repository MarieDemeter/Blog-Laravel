<?php

namespace Tests\Feature;

use App\Models\Article;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateCommentAPITest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_status()
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->postJson('/api/comment', [
            'article_id' => 1,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);
        $response->assertStatus(201);
    }

    public function test_the_api_comment_return_json_file_with_correct_data()
    {
        $this->seed(DatabaseSeeder::class);
        $article = Article::latest()->first();


        $response = $this->postJson('/api/comment', [
            'article_id' => $article->id,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);

        $response->assertJsonPath('article_id', $article->id);
        $response->assertJsonPath('content', 'bla bla bla');
        $response->assertJsonPath('pseudo', 'test');
        $response->assertJsonPath('email', 'test@test.fr');
    }

    public function test_the_api_comment_send_data_to_bdd()
    {
        $this->seed(DatabaseSeeder::class);
        $article = Article::latest()->first();

        $response = $this->postJson('/api/comment', [
            'article_id' => $article->id,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);
        
        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);
    }
}
