<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    /** @test */
    public function testRegister()
    {
        $data = factory(\App\User::class)->make()->toArray();

        $response = $this->json('POST', route('register'), $data);

        $response->assertStatus(201);
    }

    /** @test */
    public function testLogin()
    {
        User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $response = $this->json('POST', route('login'), [
            'email' => 'test@gmail.com',
            'password' => 'test1234'
        ]);

        // $user = factory(User::class)->create();
        // $response = $this->post(route('login'), [
        //     'email' => $user->email,
        //     'password' => $user->password
        // ]);
        // dd($user);
        // 왜안될까...?
        // $data = factory(\App\User::class)->make()->toArray();
        // $response = $this->json('POST', route('login'), [
        //     'email' => $data['email'],
        //     'password'=> $data['password']
        // ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());

        User::where('email', 'test@gmail.com')->delete();
    }

    /** @test */
    public function testCurrentUser()
    {
        $user = User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->json('POST', route('user'));

        $response->assertStatus(200);
    }

    /** @test */
    public function testLogout()
    {
        $user = User::create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('test1234')
        ]);


        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->json('GET', route('logout'));

        $response->assertStatus(200);
    }
}
