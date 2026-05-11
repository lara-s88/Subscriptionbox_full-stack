<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    #[Test]
    public function it_rejects_invalid_account_type()
    {
        $response = $this->post('/login', [
            'account_type' => 'superuser',
            'email'        => 'test@test.com',
            'password'     => 'password123',
        ]);
        $response->assertSessionHasErrors('account_type');
    }

    #[Test]
    public function it_rejects_empty_email()
    {
        $response = $this->post('/login', [
            'account_type' => 'customer',
            'email'        => '',
            'password'     => 'password123',
        ]);
        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function it_rejects_wrong_password()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test@test.com',
            'password'   => Hash::make('correctpassword'),
        ]);

        $response = $this->post('/login', [
            'account_type' => 'customer',
            'email'        => 'test@test.com',
            'password'     => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function it_logs_in_valid_customer()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test@test.com',
            'password'   => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'account_type' => 'customer',
            'email'        => 'test@test.com',
            'password'     => 'password123',
        ]);
        $response->assertRedirect(route('dashboard'));
    }
}
