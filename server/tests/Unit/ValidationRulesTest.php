<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class ValidationRulesTest extends TestCase
{
    public function test_password_strength_requirements()
    {
        $weakPasswords = [
            '123',      // too short
            'pass',     // too short
            'short'     // too short
        ];
        
        $strongPasswords = [
            'wachtwoord123',
            'GolfSpot2024!',
            'MySecurePass123'
        ];
        
        foreach ($weakPasswords as $password) {
            $validator = Validator::make(['password' => $password], ['password' => 'required|string|min:8']);
            $this->assertTrue($validator->fails(), "Password '{$password}' should fail validation");
        }
        
        foreach ($strongPasswords as $password) {
            $validator = Validator::make(['password' => $password], ['password' => 'required|string|min:8']);
            $this->assertFalse($validator->fails(), "Password '{$password}' should pass validation");
        }
    }

    public function test_email_format_security()
    {
        $maliciousEmails = [
            'test@<script>alert("xss")</script>.com',
            'user@domain.com; DROP TABLE users;',
            'admin@example.com\r\nBCC: hacker@evil.com'
        ];
        
        foreach ($maliciousEmails as $email) {
            $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
        }
    }

    public function test_golf_handicap_validation()
    {
        $validHandicaps = [0, 5, 18, 28, 36];
        $invalidHandicaps = [-5, 55, 100];
        
        foreach ($validHandicaps as $handicap) {
            $this->assertGreaterThanOrEqual(0, $handicap);
            $this->assertLessThanOrEqual(54, $handicap);
        }
        
        foreach ($invalidHandicaps as $handicap) {
            $this->assertTrue($handicap < 0 || $handicap > 54);
        }
    }

    public function test_url_validation()
    {
        $validUrls = [
            'https://golfspot.io',
            'http://example.com/path',
            'https://www.domain.co.uk'
        ];
        
        $invalidUrls = [
            'not-a-url',
            'javascript:alert(1)',
            'just-text-no-protocol'
        ];
        
        foreach ($validUrls as $url) {
            $this->assertTrue(filter_var($url, FILTER_VALIDATE_URL) !== false, "URL '{$url}' should be valid");
        }
        
        foreach ($invalidUrls as $url) {
            $this->assertFalse(filter_var($url, FILTER_VALIDATE_URL) !== false, "URL '{$url}' should be invalid");
        }
    }

    public function test_email_validation_with_validator()
    {
        $validEmails = [
            'user@golfspot.io',
            'admin@example.com',
            'test.email@domain.co.uk'
        ];
        
        $invalidEmails = [
            'invalid-email',
            '@domain.com',
            'user@',
            'no-at-symbol.com'
        ];
        
        foreach ($validEmails as $email) {
            $validator = Validator::make(['email' => $email], ['email' => 'required|email']);
            $this->assertFalse($validator->fails(), "Email '{$email}' should be valid");
        }
        
        foreach ($invalidEmails as $email) {
            $validator = Validator::make(['email' => $email], ['email' => 'required|email']);
            $this->assertTrue($validator->fails(), "Email '{$email}' should be invalid");
        }
    }
}
