<?php

namespace Tests\Feature;

use App\User;
use App\Todo;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $userId;

    protected $token;

    /** @test */
    public function testIndex()
    {
        $this->authenticate();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->get(route('index.todo'))
            ->assertStatus(200);
    }

    /** @test */
    public function testStore()
    {
        $this->withoutExceptionHandling();
        $this->authenticate();
        $data = factory(Todo::class)->make()->toArray();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('store.todo'), $data)
            ->assertStatus(201);

        $this->assertCount(1, Todo::all());
        $this->assertEquals($this->userId, Todo::first()->user_id);
    }

    /** @test */
    public function testStoreWithInvalidTitle()
    {
        $this->authenticate();
        $data = array_merge(factory(Todo::class)->make()->toArray(), ['title' => '']);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('store.todo'), $data)
            ->assertStatus(422);
    }

    /** @test */
    public function testStoreWithInvalidCompleted()
    {
        $this->authenticate();
        $data = factory(Todo::class)->make()->toArray();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('store.todo'), array_merge($data, ['completed' => 'a']))
            ->assertStatus(422);

        $this->assertCount(0, Todo::all());
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function testStoreWithInvalidToken()
    {
        $this->authenticate();
        $data          = factory(Todo::class)->make()->toArray();
        $invalid_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwO' .
            'lwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC91c2Vyc1wvbG9naW4iLCJpYXQiOjE1NzY2M' .
            'zU4NjgsImV4cCI6MTU3NjYzOTQ2OCwibmJmIjoxNTc2NjM1ODY4LCJqdGkiOiJpdVhhN2' .
            'lmQlBiS0JpWVhMIiwic3ViIjozLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE' .
            '1M2ExNGUwYjA0NzU0NmFhIn0.2CTFHA7HZ95B2rC0qottsi6wjiI_m6QGjLkfFmA9oYQ';

        $this->withHeaders(['Authorization' => 'Bearer ' . $invalid_token])
            ->post(route('store.todo'), $data)
            ->assertStatus(401);

        $this->assertCount(0, Todo::all());
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function testShow()
    {
        $this->authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->get(route('show.todo', ['id' => $todo->id]))
            ->assertStatus(200);

        $count = User::query()->where('id', '=', $this->user->id)->first()->todos()->count();
        $this->assertEquals(1, $count);
    }

    /** @test */
    public function testShowWithInvalidId()
    {
        $this->authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->get(route('show.todo', ['id' => 999]))
            ->assertStatus(404);
    }

    /** @test */
    public function testUpdate()
    {
        $this->withoutExceptionHandling();
        $this->authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $data = factory(Todo::class)->make()->toArray();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->put(route('update.todo', ['id' => $todo->id]), $data)
            ->assertStatus(200);

        $count = User::query()->where('id', '=', $todo->user_id)->first()->todos()->count();
        $this->assertEquals(1, $count);
    }

    /** @test */
    public function testUpdateWithInvalidRequest()
    {
        $this->authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->put(route('update.todo', ['id' => $todo->id]), ['title' => 'f'])
            ->assertStatus(422);
    }

    /** @test */
    public function testUpdateWithInvalidId()
    {
        $this->authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $data = factory(Todo::class)->make()->toArray();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->put(route('update.todo', ['id' => 999]), $data)
            ->assertStatus(404);
    }

    public function testUpdateWithoutAuthorization()
    {
        $this->authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $data = factory(Todo::class)->make()->toArray();

        $this->put(route('update.todo', ['id' => $todo->id]), $data)
            ->assertStatus(401);
    }

    /** @test */
    public function testDelete()
    {
        $this->authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->delete(route('destroy.todo', ['id' => $todo->id]))
            ->assertStatus(200);

        $this->assertEquals(0, $this->user->todos()->count());
    }

    public function testDeleteWithInvalidId()
    {
        $this->authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->delete(route('destroy.todo', ['id' => '9999']))
            ->assertStatus(404);

        $this->assertEquals(1, $this->user->todos()->count());
    }

    /**
     * store current user object & token as properties
     */
    private function authenticate()
    {
        $this->user   = factory(User::class)->create();
        $this->userId = $this->user->id;
        $this->token  = JWTAuth::fromUser($this->user);
    }
}
