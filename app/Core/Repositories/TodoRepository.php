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
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class TodoRepository
{
    /**
     * @param IndexTodoDto $dto
     *
     * @return Todo[]|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|Collection
     */
    public function index(IndexTodoDto $dto)
    {
        try {
            $todos = Todo::query()->where('user_id', $dto->getUserId())->orderBy('id', 'DESC')->get();
            if ($todos === null) {
                return null;
            }
            return $todos;
        } catch (QueryException $e) {
            throw new QueryException;
        }
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

        try {
            $todo->save();
            return $todo;
        } catch (QueryException $e) {
            throw new QueryException;
        }
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
        } catch (QueryException $e) {
            throw new QueryException;
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
        } catch (QueryException $e) {
            throw new QueryException;
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
        } catch (QueryException $e) {
            throw new QueryException;
        }
    }
}
