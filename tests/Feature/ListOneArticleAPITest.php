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

    public function test_print_article_status()
    {
        $this->seed(DatabaseSeeder::class);

        $firstArticle = Article::latest()->first();

        $response = $this->getJson('/api/article/' . $firstArticle->id);
        $response->assertStatus(200);
    }

    public function test_the_api_article_returns_json_file_with_correct_data()
    {
        $this->seed(DatabaseSeeder::class);
        $firstArticle = Article::latest()->first();

        $article = Article::find($firstArticle->id);

        $response = $this->getJson('/api/article/' . $firstArticle->id);

        $response->assertJson(
            fn (AssertableJson $json) => $json->where('id', $article->id)
                ->where('title', $article->title)
                ->where('content', $article->content)
                ->where('user_id', $article->user_id)
                ->etc()
        );
    }

}
