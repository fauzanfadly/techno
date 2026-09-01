<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRegisterTest extends TestCase
{
    use RefreshDatabase;

    private array $payload = [
        'name' => 'Reffi',
        'email' => 'reffi@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ];

    public function test_register_creates_user_and_returns_jwt_token(): void
    {
        $response = $this->postJson('/api/register', $this->payload);

        $response->assertStatus(201)
            ->assertJsonPath('status', 'SUCCESS')
            ->assertJsonPath('data.name', 'Reffi')
            ->assertJsonPath('data.email', 'reffi@example.com');

        // Token harus string JWT (3 segmen), BUKAN bool hasil Auth::attempt guard web
        $token = $response->json('data.token');
        $this->assertIsString($token, 'token harus string JWT, bukan bool');
        $this->assertCount(3, explode('.', $token), 'token harus JWT valid (3 segmen)');

        // Password tidak boleh bocor di response
        $this->assertArrayNotHasKey('password', $response->json('data'));

        // User benar-benar tersimpan
        $this->assertDatabaseHas('users', ['email' => 'reffi@example.com']);
    }

    public function test_registered_user_can_login(): void
    {
        $this->postJson('/api/register', $this->payload)->assertStatus(201);

        $login = $this->postJson('/api/login', [
            'email' => 'reffi@example.com',
            'password' => 'secret123',
        ]);

        $login->assertStatus(200)->assertJsonPath('status', 'SUCCESS');
        $this->assertIsString($login->json('data.token'));
    }

    public function test_register_rejects_invalid_payload(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Reffi',
            'email' => 'not-an-email',
            'password' => '123',
        ]);

        $response->assertStatus(400);
    }
}
