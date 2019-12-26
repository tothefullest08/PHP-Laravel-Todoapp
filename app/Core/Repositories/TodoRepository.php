<?php

namespace App\Core\Repositories;

use App\Http\Responses\ResponseHandler;
use App\Todo;
use App\Core\Dto\Todo\CreateTodoDto;
use App\Core\Dto\Todo\DeleteTodoDto;
use App\Core\Dto\Todo\IndexTodoDto;
use App\Core\Dto\Todo\ShowTodoDto;
use App\Core\Dto\Todo\UpdateTodoDto;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class TodoRepository
{
    public function index(IndexTodoDto $dto)
    {
        try {
            $todos = Todo::query()->where('user_id', '=', $dto->getUserId())->orderBy('id', 'DESC')->get();
            return ResponseHandler::success($todos);
        } catch (ModelNotFoundException $e) {
            return ResponseHandler::notFound($dto);
        } catch (QueryException $e) {
            return ResponseHandler::badRequest($dto, 'Database error');
        }
    }

    public function create(CreateTodoDto $dto)
    {
        $todo = new Todo;
        $todo->user_id     = $dto->getUserId();
        $todo->title       = $dto->getTitle();
        $todo->description = $dto->getDescription();

        try {
            $todo->save();
            return ResponseHandler::success($todo, 'create success', 201);
        } catch (QueryException $e) {
            return ResponseHandler::badRequest($dto, 'Database error');
        }
    }

    public function show(ShowTodoDto $dto)
    {
        try {
            $todo = Todo::query()->where('id', '=', $dto->getId())->firstOrFail();
            return ResponseHandler::success($todo);
        } catch (ModelNotFoundException $e) {
            return ResponseHandler::notFound($dto);
        } catch (QueryException $e) {
            return ResponseHandler::badRequest($dto, 'Database error');
        }
    }

    public function update(UpdateTodoDto $dto)
    {
        try {
            $todo = Todo::query()->where('id', '=', $dto->getId())->firstOrFail();

            $todo->title       = $dto->getTitle();
            $todo->description = $dto->getDescription();
            $todo->completed   = $dto->getCompleted();
            $todo->save();
            return ResponseHandler::success($todo);
        } catch (ModelNotFoundException $e) {
            return ResponseHandler::notFound($dto);
        } catch (QueryException $e) {
            return ResponseHandler::badRequest($dto, 'Database error');
        }
    }

    public function delete(DeleteTodoDto $dto)
    {
        try {
            $todo = Todo::query()->where('id', '=', $dto->getId())->firstOrFail();
            $todo->delete();
            return ResponseHandler::success($todo);
        } catch (ModelNotFoundException $e) {
            return ResponseHandler::notFound($dto);
        } catch (QueryException $e) {
            return ResponseHandler::badRequest($dto, 'Database error');
        } catch (Exception $e) {
            return new Exception('Error', 500);
        }
    }
}
