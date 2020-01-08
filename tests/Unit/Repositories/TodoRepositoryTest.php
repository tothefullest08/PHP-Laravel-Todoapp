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
        $todos =[];
        for ($i = 0; $i < 5; $i++) {
            $todos[] = $this->createTodo();
        }

        $dto = $this->factory->validDataForIndex($this->userId);
        $response = $this->repo->index($dto);

        $this->assertCount(count($todos), $response);
    }

    /** @test */
    public function testCreate()
    {
        $dto = $this->factory->validDataForCreate($this->userId);
        $todo = $this->repo->create($dto);

        $this->assertCount(1, Todo::all());
        $this->assertEquals($dto->getTitle(), $todo->getTitle());
        $this->assertEquals($dto->getDescription(), $todo->getDescription());
    }

    /** @test */
    public function testShow()
    {
        $todo = $this->createTodo();
        $dto = $this->factory->validDataForShow($todo->getId());
        $returnedTodo = $this->repo->show($dto);

        $this->assertEquals($todo->getId(), $returnedTodo->getId());
        $this->assertEquals($todo->getUserId(), $returnedTodo->getUserId());
        $this->assertEquals($todo->getTitle(), $returnedTodo->getTitle());
        $this->assertEquals($todo->getDescription(), $returnedTodo->getDescription());
    }

    /** @test */
    public function testUpdate()
    {
        $todo = $this->createTodo();
        $dto = $this->factory->validDataForUpdate($todo->getId());
        $updatedTodo = $this->repo->update($dto);

        $this->assertEquals($todo->getId(), $updatedTodo->getId());
        $this->assertEquals($todo->getUserId(), $updatedTodo->getUserId());
        $this->assertNotEquals($todo->getTitle(), $updatedTodo->getTitle());
        $this->assertNotEquals($todo->getDescription(), $updatedTodo->getDescription());
    }

    /** @test */
    public function testDelete()
    {
        $todo = $this->createTodo();
        $this->assertCount(1, Todo::all());

        $dto = $this->factory->validDataForDelete($todo->getId());
        $this->repo->delete($dto);

        $this->assertCount(0, Todo::all());
    }
}
