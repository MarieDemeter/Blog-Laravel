<?php

namespace Tests\Feature;

use App\Models\Article;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ListOneArticleAPITest extends TestCase
{
    use RefreshDatabase;

    public function test_the_api_article_returns_json_file_with_correct_data()
    {
        Article::factory(100)->forUser()->create();
        //$this->seed(DatabaseSeeder::class);
        $article = Article::latest()->first();

        $response = $this->getJson('/api/articles/'.$article->id);
        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) => $json->where('id', $article->id)
                ->where('title', $article->title)
                ->where('content', $article->content)
                ->where('user_id', $article->user_id)
                ->etc()
        );
    }

    public function test_the_api_article_returns_a_404_error_if_article_id_do_not_exist()
    {
        $response = $this->getJson('/api/articles/1');
        $response->assertStatus(404);
    }
}
