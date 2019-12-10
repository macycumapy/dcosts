<?php

namespace Tests\Unit\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $data = [
            'name' => 'name',
            'email' => 'test@test.ru',
            'password' => 'pass'
        ];

        $this->post('/api/register',$data)
            ->assertCreated();

        $this->post('/api/register',$data)
            ->assertStatus(422);

        return $data;
    }

    public function testLogin()
    {
        Artisan::call('passport:install');

        $data = [
            'email' => 'test@test.ru',
            'password' => 'pass'
        ];

        $this->post('/api/login',$data)
            ->assertStatus(422);

        $this->testRegister();

        $this->post('/api/login',$data)
            ->assertOk()
            ->assertJsonStructure(['access_token','expires_in','user']);

    }

    public function testLogout()
    {
        Passport::actingAs(factory(User::class)->create());

        $this->post('/api/logout')
            ->assertOk();
    }
}
