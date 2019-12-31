<?php

namespace Tests\Feature;

use App\User;
use App\Todo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function testIndex()
    {
        parent::authenticate();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->get(route('index.todo'))
            ->assertStatus(200);
    }

    /** @test */
    public function testCreate()
    {
        parent::authenticate();
        $data = factory(Todo::class)->make()->toArray();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('create.todo'), $data)
            ->assertStatus(201);

        $this->assertCount(1, Todo::all());
        $this->assertEquals($this->userId, Todo::first()->user_id);
    }

    /** @test */
    public function testCreateWithInvalidTitle()
    {
        parent::authenticate();
        $data = array_merge(factory(Todo::class)->make()->toArray(), ['title' => '']);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('create.todo'), $data)
            ->assertStatus(422);
    }

    /** @test */
    public function testCreateWithInvalidCompleted()
    {
        parent::authenticate();
        $data = factory(Todo::class)->make()->toArray();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('create.todo'), array_merge($data, ['completed' => 'a']))
            ->assertStatus(422);

        $this->assertCount(0, Todo::all());
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function testCreateWithInvalidToken()
    {
        parent::authenticate();
        $data          = factory(Todo::class)->make()->toArray();
        $invalid_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwO' .
            'lwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC91c2Vyc1wvbG9naW4iLCJpYXQiOjE1NzY2M' .
            'zU4NjgsImV4cCI6MTU3NjYzOTQ2OCwibmJmIjoxNTc2NjM1ODY4LCJqdGkiOiJpdVhhN2' .
            'lmQlBiS0JpWVhMIiwic3ViIjozLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE' .
            '1M2ExNGUwYjA0NzU0NmFhIn0.2CTFHA7HZ95B2rC0qottsi6wjiI_m6QGjLkfFmA9oYQ';

        $this->withHeaders(['Authorization' => 'Bearer ' . $invalid_token])
            ->post(route('create.todo'), $data)
            ->assertStatus(401);

        $this->assertCount(0, Todo::all());
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function testShow()
    {
        parent::authenticate();
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
        parent::authenticate();
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
        parent::authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $data = factory(Todo::class)->make()->toArray();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->put(route('update.todo', ['id' => $todo->id]), array_merge($data, ['completed' => 1]))
            ->assertStatus(200);

        $count = User::query()->where('id', '=', $todo->user_id)->first()->todos()->count();
        $this->assertEquals(1, $count);
    }

    /** @test */
    public function testUpdateWithInvalidRequest()
    {
        parent::authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $data = factory(Todo::class)->make()->toArray();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->put(route('update.todo', ['id' => $todo->id]), array_merge($data, ['title' => 'a']))
            ->assertStatus(422);
    }

    /** @test */
    public function testUpdateWithInvalidId()
    {
        parent::authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $data = factory(Todo::class)->make()->toArray();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->put(route('update.todo', ['id' => 999]), array_merge($data, ['completed' => 1]))
            ->assertStatus(404);
    }

    /** @test */
    public function testUpdateWithoutAuthorization()
    {
        parent::authenticate();
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
        parent::authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->delete(route('destroy.todo', ['id' => $todo->id]))
            ->assertStatus(200);

        $this->assertEquals(0, $this->user->todos()->count());
    }

    /** @test */
    public function testDeleteWithInvalidId()
    {
        parent::authenticate();
        $todo          = factory(Todo::class)->make();
        $todo->user_id = $this->userId;
        $todo->save();

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->delete(route('destroy.todo', ['id' => '9999']))
            ->assertStatus(404);

        $this->assertEquals(1, $this->user->todos()->count());
    }
}
