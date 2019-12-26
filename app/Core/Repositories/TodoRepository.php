<?php

namespace App\Core\Repositories;

use Exception;
use App\Todo;
use App\Core\Dto\Todo\CreateTodoDto;
use App\Core\Dto\Todo\DeleteTodoDto;
use App\Core\Dto\Todo\IndexTodoDto;
use App\Core\Dto\Todo\ShowTodoDto;
use App\Core\Dto\Todo\UpdateTodoDto;
use App\Http\Responses\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class TodoRepository
{
    /**
     * @param IndexTodoDto $dto
     *
     * @return JsonResponse
     */
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

    /**
     * @param CreateTodoDto $dto
     *
     * @return JsonResponse
     */
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

    /**
     * @param ShowTodoDto $dto
     *
     * @return JsonResponse
     */
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

    /**
     * @param UpdateTodoDto $dto
     *
     * @return JsonResponse
     */
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

    /**
     * @param DeleteTodoDto $dto
     *
     * @return Exception|JsonResponse
     */
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
