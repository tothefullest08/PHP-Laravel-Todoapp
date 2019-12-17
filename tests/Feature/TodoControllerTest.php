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
        $this->authenticate();
        $data = factory(Todo::class)->make()->toArray();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('store.todo'), $data)
            ->assertStatus(201);

        $this->assertCount(1, Todo::all());
        $this->assertEquals($this->user->id, Todo::first()->user_id);
    }

    /** @test */
    public function testStoreWithInvalidTitle()
    {
        $this->withoutExceptionHandling();
        $this->authenticate();
        $data = factory(Todo::class)->make()->toArray();

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->post(route('store.todo'), array_merge($data, ['title' => 'aa']))
            ->assertStatus(400);

        $this->assertCount(0, Todo::all());
    }

    /** @test */
    public function testShow()
    {
        $this->authenticate();
        $todo = factory(Todo::class)->make();
        $this->user->todos()->save($todo);

        $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->get(route('show.todo', ['id' => $this->user->todos()->first()->id]))
            ->assertStatus(200);

        $count = User::where('email', $this->user->email)->first()->todos()->count();
        $this->assertEquals(1, $count);
    }

    /** @test */
    public function testUpdate()
    {
        $this->withoutExceptionHandling();
        $this->authenticate();
        $todo = factory(Todo::class)->make();
        $this->user->todos()->save($todo);
        $userId = $this->user->todos()->first()->id;

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->put(route('update.todo', ['id' => $userId]), factory(Todo::class)->make()->toArray())
            ->assertStatus(200);

        $count = User::where('email', $this->user->email)->first()->todos()->count();
        $this->assertEquals(1, $count);
    }

    /** @test */
    public function testDelete()
    {
        $this->authenticate();
        $todo = factory(Todo::class)->make();
        $this->user->todos()->save($todo);

        $this->WithHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->delete(route('destroy.todo', ['id' => $this->user->todos()->first()->id]))
            ->assertStatus(200);

        $this->assertEquals(0, $this->user->todos()->count());
    }

    /**
     * store current user object & token as properties
     */
    private function authenticate()
    {
        $this->user  = factory(User::class)->create();
        $this->token = JWTAuth::fromUser($this->user);
    }
}
