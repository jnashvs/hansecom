<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisteredNotificationEmail;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_registers_a_new_user_and_returns_a_jwt_token()
    {
        Mail::fake();

        $response = $this->postJson('/api/v1/auth/create', [
            'name' => 'Test User',
            'email' => 'test23232@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'success' => true,
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test23232@example.com',
                ],
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test23232@example.com',
        ]);

        Mail::assertQueued(UserRegisteredNotificationEmail::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_fails_to_register_with_an_existing_email()
    {
        User::factory()->create(['email' => 'test23232@example.com']);

        $response = $this->postJson('/api/v1/auth/create', [
            'name' => 'Test User',
            'email' => 'test23232@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
}
