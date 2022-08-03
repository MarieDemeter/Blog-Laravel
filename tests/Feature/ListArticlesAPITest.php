<?php

namespace Tests\Feature;

use App\Models\Article;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ListArticlesAPITest extends TestCase
{
    use RefreshDatabase;

    public function test_list_articles_status()
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->getJson('/api');
        $response->assertStatus(200);
    }

    public function test_the_api_articles_returns_a_JSON_file_with_correct_data()
    {
        $this->seed(DatabaseSeeder::class);

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

    public function test_the_api_articles_returns_a_JSON_file_with_all_attributs()
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->getJson('/api');

        $response->assertJson(
            fn (AssertableJson $json) => $json->hasAll('current_page', 'data', 'from', 'last_page', 'last_page_url', 'links', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total')
                ->etc()
        );
    }
}
