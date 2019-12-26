<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $token;

    /** @test */
    public function testRegister()
    {
        $data = factory(User::class)->make()->toArray();

        $this->post(route('register'), $data)
            ->assertStatus(201);

        $this->assertCount(1, User::all());
        $this->assertEquals($data['email'], User::first()->email);
    }

    /** @test */
    public function testRegisterWithInvalidEmail()
    {
        $data = factory(User::class)->make()->toArray();

        $this->post(route('register'), array_merge($data, ['email' => '111']))
            ->assertStatus(422);
    }

    /** @test */
    public function testRegisterWithinValidPassword()
    {
        $data = factory(User::class)->make()->toArray();

        $this->post(route('register'), array_merge($data, ['password' => '1']))
            ->assertStatus(422);
    }

    /** @test */
    public function testRegisterWithExistingEmail()
    {
        $user  = factory(User::class)->create();
        $email = $user->email;
        $data  = array_merge(factory(User::class)->make()->toArray(), ['email' => $email]);

        $this->post(route('register'), $data)
            ->assertStatus(422);

        $this->assertCount(1, User::all());
    }

    /** @test */
    public function testGetUser()
    {
        $this->authenticate();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('currentUser'))
            ->assertStatus(200);
    }

    /** @test */
    public function testGetUserWithInvalidToken()
    {
        $this->authenticate();

        $this->withHeaders(['Authorization' => 'Bearer ' . '1111111'])
            ->post(route('currentUser'))
            ->assertStatus(401);
    }

    private function authenticate()
    {
        $this->user  = factory(User::class)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }
}
