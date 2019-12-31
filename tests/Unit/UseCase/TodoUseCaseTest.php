<?php

namespace Tests\Unit\UseCase;

use App\Core\Services\Todo\CreateTodoUseCase;
use App\Core\Services\Todo\DeleteTodoUseCase;
use App\Core\Services\Todo\IndexTodoUseCase;
use App\Core\Services\Todo\ShowTodoUseCase;
use App\Core\Services\Todo\UpdateTodoUseCase;
use App\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Unit\Factories\TodoDtoFactory;

class TodoUseCaseTest extends TestCase
{
    use DatabaseMigrations;

    private $factory;

    private $registerUserUseCase;

    private $indexTodoUseCase;

    private $createTodoUseCase;

    private $showTodoUseCase;

    private $updateTodoUseCase;

    private $deleteTodoUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = app(TodoDtoFactory::class);
        $this->indexTodoUseCase = app(IndexTodoUseCase::class);
        $this->createTodoUseCase = app(CreateTodoUseCase::class);
        $this->showTodoUseCase = app(ShowTodoUseCase::class);
        $this->updateTodoUseCase = app(UpdateTodoUseCase::class);
        $this->deleteTodoUseCase = app(DeleteTodoUseCase::class);

        $this->authenticate();
    }

    /** @test */
    public function testIndex()
    {
        $dto = $this->factory->validDataForIndex($this->userId);
        $response = $this->indexTodoUseCase->execute($dto);

        $this->assertNotNull($response);
    }

    /** @test */
    public function testCreate()
    {
        $dto = $this->factory->validDataForCreate($this->userId);
        $response = $this->createTodoUseCase->execute($dto);

        $this->assertEquals($dto->getTitle(), $response->title);
        $this->assertEquals($dto->getDescription(), $response->description);
        $this->assertEquals($dto->getUserId(), $response->user_id);
    }

    /** @test */
    public function testShow()
    {
        $todo = $this->createTodo();

        $dto = $this->factory->validDataForShow($todo->id);
        $this->showTodoUseCase->execute($dto);

        $this->assertEquals($dto->getId(), $this->userId);
    }

    /** @test */
    public function testUpdate()
    {
        $todo = $this->createTodo();

        $dto = $this->factory->validDataForUpdate($todo->id);
        $this->updateTodoUseCase->execute($dto);

        $this->assertEquals($dto->getId(), $this->userId);
    }

    /** @test */
    public function testDelete()
    {
        $todo = $this->createTodo();

        $dto = $this->factory->validDataForDelete($todo->id);
        $this->deleteTodoUseCase->execute($dto);

        $this->assertCount(0, Todo::all());
    }

    /** @test */
    public function testDeleteWithInvalidId()
    {
        $this->createTodo();

        $this->expectException(ModelNotFoundException::class);
        $dto = $this->factory->validDataForDelete(333);
        $this->deleteTodoUseCase->execute($dto);
    }
}
