<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testRegister()
    {
        $data = [
            'name' => 'name',
            'email' => 'test@test.ru',
            'password' => 'pass'
        ];

        $this->postJson('/api/register',$data)
            ->assertCreated();

        $this->postJson('/api/register',$data)
            ->assertStatus(422);

    }

    public function testLogin()
    {
        Artisan::call('passport:install');

        $data = [
            'email' => 'test@test.ru',
            'password' => 'password'
        ];

        $this->postJson('/api/login',$data)
            ->assertStatus(422);

        factory(User::class)->create(array_merge($data,['password'=>Hash::make($data['password'])]));

        $this->postJson('/api/login',$data)
            ->assertOk()
            ->assertJsonStructure(['access_token','expires_in','user']);

    }

    public function testLogout()
    {
        Passport::actingAs(factory(User::class)->create());

        $this->postJson('/api/logout')
            ->assertOk();
    }
}
