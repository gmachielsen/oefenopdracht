<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\News;
use Carbon\Carbon;

class NewsTest extends TestCase
{
    public function test_can_fetch_published_news_list()
    {
        // Create some test news articles
        News::create([
            'title' => 'First News Article',
            'description' => 'This is the first news article',
            'content' => 'Content of the first news article',
            'image_url' => 'https://example.com/image1.jpg',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        News::create([
            'title' => 'Second News Article',
            'description' => 'This is the second news article',
            'content' => 'Content of the second news article',
            'image_url' => 'https://example.com/image2.jpg',
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Create an unpublished article (should not appear in results)
        News::create([
            'title' => 'Unpublished Article',
            'description' => 'This should not appear',
            'content' => 'Unpublished content',
            'is_published' => false,
        ]);

        $response = $this->getJson('/api/news');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'image_url',
                            'published_at',
                            'created_at'
                        ]
                    ]
                ])
                ->assertJsonPath('success', true);

        // Should only return published articles
        $this->assertCount(2, $response->json('data'));
        
        // Check order (newest first by published_at)
        $articles = $response->json('data');
        $this->assertEquals('Second News Article', $articles[0]['title']);
        $this->assertEquals('First News Article', $articles[1]['title']);
    }

    public function test_can_fetch_specific_published_news_article()
    {
        $news = News::create([
            'title' => 'Test News Article',
            'description' => 'Test description',
            'content' => 'This is the full content of the test article',
            'image_url' => 'https://example.com/test-image.jpg',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->getJson("/api/news/{$news->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'title',
                        'description',
                        'content',
                        'image_url',
                        'is_published',
                        'published_at',
                        'created_at',
                        'updated_at'
                    ]
                ])
                ->assertJsonPath('success', true)
                ->assertJsonPath('data.title', 'Test News Article')
                ->assertJsonPath('data.description', 'Test description')
                ->assertJsonPath('data.content', 'This is the full content of the test article')
                ->assertJsonPath('data.image_url', 'https://example.com/test-image.jpg')
                ->assertJsonPath('data.is_published', true);
    }

    public function test_cannot_fetch_unpublished_news_article()
    {
        $news = News::create([
            'title' => 'Unpublished Article',
            'description' => 'This should not be accessible',
            'content' => 'Unpublished content',
            'is_published' => false,
        ]);

        $response = $this->getJson("/api/news/{$news->id}");

        $response->assertStatus(404);
    }

    public function test_returns_404_for_nonexistent_news_article()
    {
        $response = $this->getJson('/api/news/999999');

        $response->assertStatus(404);
    }

    public function test_news_list_only_shows_published_articles()
    {
        // Create mix of published and unpublished articles
        News::create([
            'title' => 'Published Article 1',
            'description' => 'This is published',
            'content' => 'Published content 1',
            'is_published' => true,
            'published_at' => now()->subHours(2),
        ]);

        News::create([
            'title' => 'Unpublished Article',
            'description' => 'This is not published',
            'content' => 'Unpublished content',
            'is_published' => false,
        ]);

        News::create([
            'title' => 'Published Article 2',
            'description' => 'This is also published',
            'content' => 'Published content 2',
            'is_published' => true,
            'published_at' => now()->subHours(1),
        ]);

        $response = $this->getJson('/api/news');

        $response->assertStatus(200);
        
        $articles = $response->json('data');
        $this->assertCount(2, $articles);
        
        // Verify only published articles are returned
        foreach ($articles as $article) {
            $this->assertNotEquals('Unpublished Article', $article['title']);
        }
        
        // Verify correct order (newest first)
        $this->assertEquals('Published Article 2', $articles[0]['title']);
        $this->assertEquals('Published Article 1', $articles[1]['title']);
    }

    public function test_news_list_returns_correct_fields()
    {
        News::create([
            'title' => 'Test Article',
            'description' => 'Test description',
            'content' => 'Test content that should not appear in list',
            'image_url' => 'https://example.com/test.jpg',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->getJson('/api/news');

        $response->assertStatus(200);
        
        $article = $response->json('data')[0];
        
        // Should include these fields
        $this->assertArrayHasKey('id', $article);
        $this->assertArrayHasKey('title', $article);
        $this->assertArrayHasKey('description', $article);
        $this->assertArrayHasKey('image_url', $article);
        $this->assertArrayHasKey('published_at', $article);
        $this->assertArrayHasKey('created_at', $article);
        
        // Should NOT include content in list view
        $this->assertArrayNotHasKey('content', $article);
    }

    public function test_news_detail_returns_all_fields()
    {
        $news = News::create([
            'title' => 'Detailed Article',
            'description' => 'Detailed description',
            'content' => 'This is the full content that should appear in detail view',
            'image_url' => 'https://example.com/detail.jpg',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->getJson("/api/news/{$news->id}");

        $response->assertStatus(200);
        
        $article = $response->json('data');
        
        // Should include all fields including content
        $this->assertArrayHasKey('id', $article);
        $this->assertArrayHasKey('title', $article);
        $this->assertArrayHasKey('description', $article);
        $this->assertArrayHasKey('content', $article);
        $this->assertArrayHasKey('image_url', $article);
        $this->assertArrayHasKey('is_published', $article);
        $this->assertArrayHasKey('published_at', $article);
        $this->assertArrayHasKey('created_at', $article);
        $this->assertArrayHasKey('updated_at', $article);
        
        $this->assertEquals('This is the full content that should appear in detail view', $article['content']);
    }
}
