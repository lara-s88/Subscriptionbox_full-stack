<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

   #[Test]
    public function it_shows_register_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    #[Test]
    public function it_rejects_short_password()
    {
        $response = $this->post('/register', [
            'account_type' => 'customer',
            'first_name'   => 'Test',
            'last_name'    => 'User',
            'email'        => 'test@test.com',
            'password'     => 'short',
        ]);
        $response->assertSessionHasErrors('password');
    }

    #[Test]
    public function it_rejects_missing_first_name()
    {
        $response = $this->post('/register', [
            'account_type' => 'customer',
            'first_name'   => '',
            'last_name'    => 'User',
            'email'        => 'test@test.com',
            'password'     => 'password123',
        ]);
        $response->assertSessionHasErrors('first_name');
    }

    #[Test]
    public function it_rejects_duplicate_email()
    {
        User::create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test@test.com',
            'password'   => bcrypt('password123'),
        ]);

        $response = $this->post('/register', [
            'account_type' => 'customer',
            'first_name'   => 'Another',
            'last_name'    => 'User',
            'email'        => 'test@test.com',
            'password'     => 'password123',
        ]);
        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function it_registers_a_valid_customer()
    {
        $response = $this->post('/register', [
            'account_type' => 'customer',
            'first_name'   => 'Test',
            'last_name'    => 'User',
            'email'        => 'newuser@test.com',
            'password'     => 'password123',
        ]);
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', ['email' => 'newuser@test.com']);
    }
}
