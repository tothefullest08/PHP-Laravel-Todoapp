<?php

namespace Tests\Feature;

use App\User;
use App\Todo;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoControllerTest extends TestCase
{
    protected $user;

    /** @test */
    public function testIndex()
    {
        $token    = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json(
            'GET',
            route('index.todo')
        );

        $response->assertStatus(200);
    }

    public function authenticate()
    {
        $user = User::create([
            'email'    => 'test@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $this->user = $user;
        $token      = JWTAuth::fromUser($user);

        return $token;
    }

    /** @test */
    public function testStore()
    {
        $token    = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json(
            'POST',
            route('store.todo'),
            factory(Todo::class)->make()->toArray()
        );

        $response->assertStatus(201);
    }

    /** @test */
    public function testShow()
    {
        $token = $this->authenticate();
        $todo  = factory(Todo::class)->make();
        $this->user->todos()->save($todo);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json(
            'GET',
            route('show.todo', ['id' => $this->user->todos()->first()->id])
        );

        $response->assertStatus(200);
        $count = User::where('email', 'test@gmail.com')->first()->todos()->count();
        $this->assertEquals(1, $count);
    }

    /** @test */
    public function testUpdate()
    {
        $token = $this->authenticate();
        $todo  = factory(Todo::class)->make();
        $this->user->todos()->save($todo);

        $response = $this->WithHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json(
            'PUT',
            route('update.todo', ['id' => $this->user->todos()->first()->id]),
            [
                'title'       => 'updated title',
                'description' => 'updated description',
                'completed'   => 1
            ]
        );
        $response->assertStatus(200);
        $this->assertEquals('updated title', $this->user->todos()->first()->title);
    }

    /** @test */
    public function testDelete()
    {
        $token = $this->authenticate();
        $todo  = factory(Todo::class)->make();
        $this->user->todos()->save($todo);

        $response = $this->WithHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json(
            'DELETE',
            route('destroy.todo', ['id' => $this->user->todos()->first()->id])
        );

        $response->assertStatus(200);
        $this->assertEquals(0, $this->user->todos()->count());
    }
}
