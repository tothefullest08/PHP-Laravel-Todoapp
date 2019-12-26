<?php

namespace App\Http\Controllers;

use App\Core\Dto\CreateTodoDto;
use App\Core\Dto\IndexTodoDto;
use App\Core\Services\Todo\CreateTodoUseCase;
use App\Core\Services\Todo\IndexTodoUseCase;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Responses\BadRequestResponse;
use App\Http\Responses\CreateSuccessResponse;
use App\Http\Responses\RequestSuccessResponse;
use App\Todo;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    /**
     * @var
     */
    protected $userId;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $dto = new IndexTodoDto(request()->user()->id);
        $useCaseResponse = (new IndexTodoUseCase)->index($dto);

        return $useCaseResponse;
    }

    /**
     * @param CreateTodoRequest $request
     *
     * @return CreateSuccessResponse|JsonResponse
     */
    public function create(CreateTodoRequest $request)
    {
        $dto = new CreateTodoDto(request()->user()->id, $request->getTitle(), $request->getDescription());
        $useCaseResponse = (new CreateTodoUseCase)->create($dto);

        return $useCaseResponse;
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $todo = Todo::query()->where('id', '=', $id)->firstOrFail();

        return (new RequestSuccessResponse($todo))->getResult();
    }

    /**
     * @param UpdateTodoRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateTodoRequest $request, $id): JsonResponse
    {
        $todo = Todo::query()->where('id', '=', $id)->firstOrFail();

        try {
            $todo->title       = $request->getTitle();
            $todo->description = $request->getDescription();
            $todo->completed   = $request->getCompleted();
        } catch (QueryException $e) {
            return (new BadRequestResponse($todo))->getResult();
        }

        return (new RequestSuccessResponse($todo))->getResult();
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id): JsonResponse
    {
        $todo = Todo::query()->where('id', $id)->firstOrFail();

        try {
            $todo->delete();
        } catch (QueryException $e) {
            return (new BadRequestResponse($todo))->getResult();
        }

        return (new RequestSuccessResponse($todo))->getResult();
    }
}
