<?php

namespace App\Http\Controllers;

use App\Core\Dto\Todo\CreateTodoDto;
use App\Core\Dto\Todo\DeleteTodoDto;
use App\Core\Dto\Todo\IndexTodoDto;
use App\Core\Dto\Todo\ShowTodoDto;
use App\Core\Dto\Todo\UpdateTodoDto;
use App\Core\Services\Todo\CreateTodoUseCase;
use App\Core\Services\Todo\DeleteTodoUseCase;
use App\Core\Services\Todo\IndexTodoUseCase;
use App\Core\Services\Todo\ShowTodoUseCase;
use App\Core\Services\Todo\UpdateTodoUseCase;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    /**
     * @param IndexTodoUseCase $useCase
     *
     * @return JsonResponse
     */
    public function index(IndexTodoUseCase $useCase): JsonResponse
    {
        $dto             = (new IndexTodoDto())->setUserId(request()->user()->id);
        $useCaseResponse = $useCase->execute($dto);

        return $useCaseResponse;
    }

    /**
     * @param CreateTodoRequest $request
     * @param CreateTodoUseCase $useCase
     *
     * @return JsonResponse
     */
    public function create(CreateTodoRequest $request, CreateTodoUseCase $useCase)
    {
        $dto             = (new CreateTodoDto())
            ->setUserId(request()->user()->id)
            ->setTitle($request->input('title'))
            ->setDescription($request->input('description'));
        $useCaseResponse = $useCase->execute($dto);

        return $useCaseResponse;
    }

    /**
     * @param int $id
     * @param ShowTodoUseCase $useCase
     *
     * @return JsonResponse
     */
    public function show(int $id, showTodoUseCase $useCase): JsonResponse
    {
        $dto             = (new showTodoDto())->setId($id);
        $useCaseResponse = $useCase->execute($dto);

        return $useCaseResponse;
    }

    /**
     * @param UpdateTodoRequest $request
     * @param int $id
     * @param UpdateTodoUseCase $useCase
     *
     * @return JsonResponse
     */
    public function update(UpdateTodoRequest $request, int $id, UpdateTodoUseCase $useCase): JsonResponse
    {
        $dto = (new UpdateTodoDto)
            ->setId($id)
            ->setTitle($request->input('title'))
            ->setDescription($request->input('description'))
            ->setCompleted($request->input('completed'));

        $useCaseResponse = $useCase->execute($dto);

        return $useCaseResponse;
    }

    /**
     * @param int $id
     * @param DeleteTodoUseCase $useCase
     *
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteTodoUseCase $useCase): JsonResponse
    {
        $dto             = (new deleteTodoDto)->setId($id);
        $useCaseResponse = $useCase->execute($dto);

        return $useCaseResponse;
    }
}
