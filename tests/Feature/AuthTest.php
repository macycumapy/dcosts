<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @testdox Регистрация и попытка повторной регистрации на тот же емейл
     * @dataProvider dataProvider
     */
    public function testRegister(array $data): void
    {
        $response = $this->postJson('/api/register', $data);
        $response->assertOk();
        $response->assertJsonStructure(['data' => ['token', 'user']]);

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * @dataProvider dataProvider
     */
    public function testLogin(array $data): void
    {
        $response = $this->postJson('/api/login', $data);
        $response->assertStatus(422);

        User::factory()->create(array_merge($data, [
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
        ]));
        $response = $this->postJson('/api/login', $data);
        $response->assertOk();
        $response->assertJsonStructure(['data' => ['token', 'user']]);
    }

    public function testLogout(): void
    {
        $response = $this->postJson('/api/logout');
        $response->assertStatus(401);

        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/logout');
        $response->assertOk();
    }

    public function dataProvider(): array
    {
        return [
          [[
              'name' => 'name',
              'email' => 'email@email.ru',
              'password' => 'password',
          ]],
        ];
    }
}
