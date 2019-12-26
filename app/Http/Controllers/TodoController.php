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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $dto             = new IndexTodoDto(request()->user()->id);
        $useCaseResponse = (new IndexTodoUseCase)->index($dto);

        return $useCaseResponse;
    }

    /**
     * @param CreateTodoRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateTodoRequest $request)
    {
        $dto = new CreateTodoDto(
            request()->user()->id,
            $request->getTitle(),
            $request->getDescription()
        );

        $useCaseResponse = (new CreateTodoUseCase)->create($dto);

        return $useCaseResponse;
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $dto             = new showTodoDto($id);
        $useCaseResponse = (new showTodoUseCase)->show($dto);

        return $useCaseResponse;
    }

    /**
     * @param UpdateTodoRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateTodoRequest $request, int $id): JsonResponse
    {
        $dto = new UpdateTodoDto(
            $id,
            $request->getTitle(),
            $request->getDescription(),
            $request->getCompleted()
        );

        $useCaseResponse = (new UpdateTodoUseCase)->update($dto);

        return $useCaseResponse;
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $dto             = new deleteTodoDto($id);
        $useCaseResponse = (new deleteTodoUseCase)->delete($dto);

        return $useCaseResponse;
    }
}
