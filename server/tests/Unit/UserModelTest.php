<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserModelTest extends TestCase
{
    public function test_user_password_is_hashed()
    {
        $user = new User();
        $user->password = Hash::make('wachtwoord123');
        
        $this->assertTrue(Hash::check('wachtwoord123', $user->password));
        $this->assertFalse(Hash::check('wrongpassword', $user->password));
    }

    public function test_user_email_validation()
    {
        $validEmails = [
            'user@golfspot.io',
            'admin@example.com',
            'test.user@domain.co.uk'
        ];
        
        foreach ($validEmails as $email) {
            $validator = Validator::make(['email' => $email], ['email' => 'required|email']);
            $this->assertFalse($validator->fails());
        }
    }

    public function test_user_birth_date_validation()
    {
        $validDates = [
            '1990-01-01',
            '1985-12-25',
            '2000-06-15'
        ];
        
        foreach ($validDates as $date) {
            $validator = Validator::make(['birth_date' => $date], ['birth_date' => 'date|before:today']);
            $this->assertFalse($validator->fails());
        }
    }

    public function test_user_age_calculation()
    {
        $birthDate = Carbon::now()->subYears(25);
        
        // Test if user is at least 18 years old (golf membership requirement)
        $age = $birthDate->diffInYears(Carbon::now());
        $this->assertGreaterThanOrEqual(18, $age);
    }

    public function test_user_fillable_attributes()
    {
        $user = new User();
        $fillable = $user->getFillable();
        
        $expectedFillable = [
            'email',
            'password',
            'first_name',
            'last_name',
            'birth_date',
            'profile_photo'
        ];
        
        foreach ($expectedFillable as $attribute) {
            $this->assertContains($attribute, $fillable);
        }
    }

    public function test_user_hidden_attributes()
    {
        $user = new User();
        $hidden = $user->getHidden();
        
        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
    }

    public function test_user_casts_attributes_correctly()
    {
        $user = new User();
        $casts = $user->getCasts();
        
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertEquals('date', $casts['birth_date']);
    }

    public function test_invalid_email_validation()
    {
        $invalidEmails = [
            'invalid-email',
            '@domain.com',
            'user@',
            'user.domain.com'
        ];
        
        foreach ($invalidEmails as $email) {
            $validator = Validator::make(['email' => $email], ['email' => 'required|email']);
            $this->assertTrue($validator->fails());
        }
    }

    public function test_simple_string_operations()
    {
        $email = 'TEST@GOLFSPOT.IO';
        $this->assertEquals('test@golfspot.io', strtolower($email));
        $this->assertTrue(str_contains($email, '@'));
    }

    public function test_simple_date_operations()
    {
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();
        
        $this->assertTrue($today->isAfter($yesterday));
        $this->assertTrue($yesterday->isBefore($today));
    }
}
