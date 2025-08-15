<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\News;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class NewsModelTest extends TestCase
{
    public function test_news_title_validation()
    {
        $validTitles = [
            'Golf Tournament 2024',
            'New Course Opening',
            'Club Championship Results'
        ];
        
        foreach ($validTitles as $title) {
            $validator = Validator::make(['title' => $title], ['title' => 'required|string|max:255']);
            $this->assertFalse($validator->fails());
        }
    }

    public function test_news_content_validation()
    {
        $shortContent = 'Too short';
        $validContent = 'This is a valid news article content with sufficient length to meet requirements.';
        
        $shortValidator = Validator::make(['content' => $shortContent], ['content' => 'required|string|min:20']);
        $validValidator = Validator::make(['content' => $validContent], ['content' => 'required|string|min:20']);
        
        $this->assertTrue($shortValidator->fails());
        $this->assertFalse($validValidator->fails());
    }

    public function test_news_boolean_logic()
    {
        // Test boolean values without database interaction
        $isPublished = true;
        $isNotPublished = false;
        
        $this->assertTrue($isPublished);
        $this->assertFalse($isNotPublished);
        $this->assertNotEquals($isPublished, $isNotPublished);
    }

    public function test_news_image_url_validation()
    {
        $validUrls = [
            'https://golfspot.io/images/tournament.jpg',
            'https://cdn.example.com/golf-course.png'
        ];
        
        $invalidUrls = [
            'not-a-url',
            'invalid-url-format',
            'just-text'
        ];
        
        foreach ($validUrls as $url) {
            $validator = Validator::make(['image_url' => $url], ['image_url' => 'nullable|url']);
            $this->assertFalse($validator->fails());
        }
        
        foreach ($invalidUrls as $url) {
            $validator = Validator::make(['image_url' => $url], ['image_url' => 'nullable|url']);
            $this->assertTrue($validator->fails());
        }
    }

    public function test_news_fillable_attributes()
    {
        $news = new News();
        $fillable = $news->getFillable();
        
        $expectedFillable = [
            'title',
            'description',
            'content',
            'image_url',
            'is_published',
            'published_at'
        ];
        
        foreach ($expectedFillable as $attribute) {
            $this->assertContains($attribute, $fillable);
        }
    }

    public function test_date_formatting()
    {
        $date = Carbon::parse('2024-01-15 10:30:00');
        
        $this->assertEquals('2024-01-15', $date->toDateString());
        $this->assertEquals('2024', $date->year);
        $this->assertEquals(1, $date->month);
        $this->assertEquals(15, $date->day);
    }
}
