<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $token;

    /** @test */
    public function testLogin()
    {
        $data = factory(User::class)->make()->toArray();
        $this->post(route('register'), $data);

        $this->post(route('login'), $data)
            ->assertStatus(200);

        $this->assertCount(1, User::all());
        $this->assertEquals($data['email'], User::first()->email);
    }

    /** @test */
    public function testUnauthorizedLogin()
    {
        $data = factory(User::class)->make()->toArray();
        $this->post(route('register'), $data);

        $this->post(route('login'), array_merge($data, ['email' => 'abcd@abc.com']))
            ->assertStatus(401);
    }

    /** @test */
    public function testLogout()
    {
        $this->authenticate();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->get(route('logout'))
            ->assertStatus(200);
    }

    private function authenticate()
    {
        $this->user  = factory(User::class)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }
}
