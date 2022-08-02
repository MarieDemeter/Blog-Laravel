<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Database\Seeders\ArticleSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_article_property()
    {
        // Create localy a model instance
        User::factory()->create();
        $article = Article::factory()
            ->make();

        // Check properties
        $this->assertIsString($article->title);
        $this->assertIsString($article->content);
        $this->assertIsInt($article->user_id);
    }

    public function test_article_seeder()
    {
        // Call the seeder for product
        $this->seed(ArticleSeeder::class);
        // Check the number of products in data base
        $this->assertDatabaseCount('articles', 100);
    }

    public function test_article_status()
    {
        $response = $this->getJson('/api/article/99');
        $response->assertStatus(200);
    }

    public function test_articles_status()
    {
        $response = $this->getJson('/api');
        $response->assertStatus(200);
    }

    public function test_comment_status()
    {
        $response = $this->postJson('/api/comment', [
            'article_id' => 1,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);
        $response->assertStatus(201);
    }

    public function test_the_api_article_returns_a_JSON_file_with_correct_data()
    {
        $article = Article::find(99);

        $response = $this->getJson('/api/article/99');

        $response->assertJson(
            fn (AssertableJson $json) => $json->where('id', 99)
                ->where('title', $article->title)
                ->where('content', $article->content)
                ->where('user_id', $article->user_id)
                ->etc()
        );
    }

    public function test_the_api_articles_returns_a_JSON_file_with_correct_data()
    {
        $articles_count_PerPage = 10;
        $firstArticle = Article::latest()->first();

        $response = $this->getJson('/api');

        $response->assertJson(
            fn (AssertableJson $json) => $json->has(
                'data',
                $articles_count_PerPage,
                fn ($json_data) => $json_data->where('id', $firstArticle->id)
                    ->where('title', $firstArticle->title)
                    ->where('content', $firstArticle->content)
                    ->where('user_id', $firstArticle->user_id)
                    ->etc()
            )
            ->etc()
        );
    }

    public function test_the_api_articles_returns_a_JSON_file_with_all_informations()
    {
        $articles_count_PerPage = 10;
        $firstArticle = Article::latest()->first();

        $response = $this->getJson('/api');

        $response->assertJson(
            fn (AssertableJson $json) => $json->hasAll('current_page', 'data', 'from', 'last_page', 'last_page_url', 'links', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total')
                 ->etc()
        );
    }

    public function test_the_api_comment_returns_a_JSON_file_with_correct_data()
    {
        $response = $this->postJson('/api/comment', [
            'article_id' => 1,
            'content' => 'bla bla bla',
            'pseudo' => 'test',
            'email' => 'test@test.fr',
        ]);

        $response->assertJsonPath('article_id', 1);
        $response->assertJsonPath('content', 'bla bla bla');
        $response->assertJsonPath('pseudo', 'test');
        $response->assertJsonPath('email', 'test@test.fr');
    }

    public function test_article_404_error()
    {
        $response = $this->getJson('/api/article/test');
        $response->assertStatus(404);
    }
}
