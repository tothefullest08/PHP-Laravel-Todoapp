<?php

namespace Tests\Unit\Repositories;

use App\Core\Repositories\TodoRepository;
use App\Todo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Unit\Factories\TodoDtoFactory;

class TodoRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private $factory;

    private $repo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticate();
        $this->factory = app(TodoDtoFactory::class);
        $this->repo = (new TodoRepository);
    }

    /** @test */
    public function testIndex()
    {
        $dto = $this->factory->validDataForIndex($this->userId);
        $this->repo->index($dto);

        $this->assertCount(0, Todo::all());
    }

    /** @test */
    public function testCreate()
    {
        $dto = $this->factory->validDataForCreate($this->userId);
        $this->repo->create($dto);

        $this->assertCount(1, Todo::all());
    }

    /** @test */
    public function testShow()
    {
        $todo = $this->createTodo();
        $dto = $this->factory->validDataForShow($todo->id);
        $response = $this->repo->show($dto);

        $this->assertEquals($todo->user_id, $response->user_id);
        $this->assertEquals($todo->title, $response->title);
        $this->assertEquals($todo->description, $response->description);
        $this->assertEquals($todo->id, $response->id);
    }

    /** @test */
    public function testUpdate()
    {
        $todo = $this->createTodo();
        $dto = $this->factory->validDataForUpdate($todo->id);
        $response = $this->repo->update($dto);

        $this->assertEquals($todo->id, $response->id);
        $this->assertEquals($todo->user_id, $response->user_id);
        $this->assertNotEquals($todo->title, $response->title);
        $this->assertNotEquals($todo->description, $response->description);
    }

    /** @test */
    public function testDelete()
    {
        $todo = $this->createTodo();

        $this->assertCount(1, Todo::all());

        $dto = $this->factory->validDataForDelete($todo->id);
        $this->repo->delete($dto);

        $this->assertCount(0, Todo::all());
    }
}
