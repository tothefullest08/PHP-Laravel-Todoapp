<?php

namespace App\Core\Repositories;

use Exception;
use App\Todo;
use App\Core\Dto\Todo\CreateTodoDto;
use App\Core\Dto\Todo\DeleteTodoDto;
use App\Core\Dto\Todo\IndexTodoDto;
use App\Core\Dto\Todo\ShowTodoDto;
use App\Core\Dto\Todo\UpdateTodoDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class TodoRepository
{
    /**
     * @param IndexTodoDto $dto
     *
     * @return Todo[]|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|Collection|null
     */
    public function index(IndexTodoDto $dto)
    {
        $todos = Todo::query()->where('user_id', $dto->getUserId())->orderBy('id', 'DESC')->get();
        if ($todos === null) {
            return null;
        }
        return $todos;
    }

    /**
     * @param CreateTodoDto $dto
     *
     * @return Todo
     */
    public function create(CreateTodoDto $dto)
    {
        $todo              = new Todo;
        $todo->user_id     = $dto->getUserId();
        $todo->title       = $dto->getTitle();
        $todo->description = $dto->getDescription();

        $todo->save();
        return $todo;
    }

    /**
     * @param ShowTodoDto $dto
     *
     * @return Todo|Builder|Model
     */
    public function show(ShowTodoDto $dto)
    {
        try {
            $todo = Todo::query()->where('id', $dto->getId())->firstOrFail();
            return $todo;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param UpdateTodoDto $dto
     *
     * @return Todo|Builder|Model
     */
    public function update(UpdateTodoDto $dto)
    {
        try {
            $todo = Todo::query()->where('id', $dto->getId())->firstOrFail();

            $todo->title       = $dto->getTitle();
            $todo->description = $dto->getDescription();
            $todo->completed   = $dto->getCompleted();
            $todo->save();
            return $todo;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param DeleteTodoDto $dto
     *
     * @return Todo|Builder|Model
     * @throws Exception
     */
    public function delete(DeleteTodoDto $dto)
    {
        try {
            $todo = Todo::query()->where('id', $dto->getId())->firstOrFail();
            $todo->delete();
            return $todo;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException;
        }
    }
}
