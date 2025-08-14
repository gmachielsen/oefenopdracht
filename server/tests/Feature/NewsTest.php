<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
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

    public function test_authenticated_admin_can_create_news_article()
    {
        // Create and authenticate user
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $newsData = [
            'title' => 'New Article',
            'description' => 'Article description',
            'content' => 'Full article content',
            'image_url' => 'https://example.com/new-image.jpg',
            'is_published' => true,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/news', $newsData);

        $response->assertStatus(201)
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
                ->assertJsonPath('data.title', 'New Article')
                ->assertJsonPath('data.description', 'Article description')
                ->assertJsonPath('data.content', 'Full article content')
                ->assertJsonPath('data.image_url', 'https://example.com/new-image.jpg')
                ->assertJsonPath('data.is_published', true);

        // Verify the article was created in the database
        $this->assertDatabaseHas('news', [
            'title' => 'New Article',
            'description' => 'Article description',
            'content' => 'Full article content',
            'image_url' => 'https://example.com/new-image.jpg',
            'is_published' => true,
        ]);
    }

    public function test_authenticated_admin_can_create_unpublished_news_article()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $newsData = [
            'title' => 'Draft Article',
            'description' => 'Draft description',
            'content' => 'Draft content',
            'is_published' => false,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/news', $newsData);

        $response->assertStatus(201)
                ->assertJsonPath('data.is_published', false)
                ->assertJsonPath('data.published_at', null);

        $this->assertDatabaseHas('news', [
            'title' => 'Draft Article',
            'is_published' => false,
        ]);
    }

    public function test_unauthenticated_user_cannot_create_news_article()
    {
        $newsData = [
            'title' => 'Unauthorized Article',
            'description' => 'Should not be created',
            'content' => 'Unauthorized content',
        ];

        $response = $this->postJson('/api/news', $newsData);

        $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function test_news_creation_validation_requires_title()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/news', [
            'description' => 'Description without title',
            'content' => 'Content without title',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title']);
    }

    public function test_news_creation_validation_requires_description()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/news', [
            'title' => 'Title without description',
            'content' => 'Content without description',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['description']);
    }

    public function test_news_creation_validation_requires_content()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/news', [
            'title' => 'Title without content',
            'description' => 'Description without content',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['content']);
    }

    public function test_news_creation_validation_image_url_must_be_valid_url()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/news', [
            'title' => 'Test Article',
            'description' => 'Test description',
            'content' => 'Test content',
            'image_url' => 'not-a-valid-url',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['image_url']);
    }

    public function test_authenticated_admin_can_update_news_article()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $news = News::create([
            'title' => 'Original Title',
            'description' => 'Original description',
            'content' => 'Original content',
            'is_published' => false,
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'content' => 'Updated content',
            'is_published' => true,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/news/{$news->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonPath('success', true)
                ->assertJsonPath('data.title', 'Updated Title')
                ->assertJsonPath('data.description', 'Updated description')
                ->assertJsonPath('data.content', 'Updated content')
                ->assertJsonPath('data.is_published', true);

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'content' => 'Updated content',
            'is_published' => true,
        ]);
    }

    public function test_authenticated_admin_can_partially_update_news_article()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $news = News::create([
            'title' => 'Original Title',
            'description' => 'Original description',
            'content' => 'Original content',
            'is_published' => false,
        ]);

        // Only update the title
        $updateData = [
            'title' => 'Only Title Updated',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/news/{$news->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonPath('data.title', 'Only Title Updated')
                ->assertJsonPath('data.description', 'Original description')
                ->assertJsonPath('data.content', 'Original content');
    }

    public function test_unauthenticated_user_cannot_update_news_article()
    {
        $news = News::create([
            'title' => 'Test Article',
            'description' => 'Test description',
            'content' => 'Test content',
        ]);

        $response = $this->putJson("/api/news/{$news->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function test_authenticated_admin_can_delete_news_article()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $news = News::create([
            'title' => 'Article to Delete',
            'description' => 'This will be deleted',
            'content' => 'Delete this content',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson("/api/news/{$news->id}");

        $response->assertStatus(200)
                ->assertJsonPath('success', true)
                ->assertJsonPath('message', 'News deleted successfully');

        $this->assertDatabaseMissing('news', [
            'id' => $news->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_delete_news_article()
    {
        $news = News::create([
            'title' => 'Protected Article',
            'description' => 'Should not be deleted',
            'content' => 'Protected content',
        ]);

        $response = $this->deleteJson("/api/news/{$news->id}");

        $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Unauthenticated.'
                ]);

        // Verify article still exists
        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Protected Article',
        ]);
    }

    public function test_returns_404_when_updating_nonexistent_news_article()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/news/999999', [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(404);
    }

    public function test_returns_404_when_deleting_nonexistent_news_article()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/news/999999');

        $response->assertStatus(404);
    }

    public function test_published_at_is_set_automatically_when_publishing()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/news', [
            'title' => 'Auto Published Article',
            'description' => 'Auto published description',
            'content' => 'Auto published content',
            'is_published' => true,
        ]);

        $response->assertStatus(201);
        
        $article = $response->json('data');
        $this->assertNotNull($article['published_at']);
        
        // Verify published_at is recent (within last minute)
        $publishedAt = Carbon::parse($article['published_at']);
        $this->assertTrue($publishedAt->diffInMinutes(now()) < 1);
    }

    public function test_can_set_custom_published_at_date()
    {
        $user = User::create([
            'email' => 'admin@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $customDate = '2024-01-15 10:30:00';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/news', [
            'title' => 'Custom Date Article',
            'description' => 'Custom date description',
            'content' => 'Custom date content',
            'is_published' => true,
            'published_at' => $customDate,
        ]);

        $response->assertStatus(201);
        
        $article = $response->json('data');
        $this->assertStringStartsWith('2024-01-15', $article['published_at']);
    }
}
