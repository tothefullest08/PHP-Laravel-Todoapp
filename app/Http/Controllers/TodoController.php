<?php

namespace App\Http\Controllers;

use App\Core\Dto\CreateTodoDto;
use App\Core\Services\Todo\CreateTodoUseCase;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Responses\BadRequestResponse;
use App\Http\Responses\CreateSuccessResponse;
use App\Http\Responses\SuccessResponse;
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
        $this->userId = request()->user()->id;
        $todos        = Todo::query()->where('user_id', $this->userId)->orderBy('id', 'DESC')->get();

        return (new SuccessResponse($todos))->getResult();
    }

    /**
     * @param CreateTodoRequest $request
     *
     * @return CreateSuccessResponse|JsonResponse
     */
    public function create(CreateTodoRequest $request)
    {
        $dto = new CreateTodoDto(request()->user()->id, $request->getTitle(), $request->getDescription());

        $userCaseResponse = (new CreateTodoUseCase)->create($dto);

        return $userCaseResponse;
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $todo = Todo::query()->where('id', '=', $id)->firstOrFail();

        return (new SuccessResponse($todo))->getResult();
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

        return (new SuccessResponse($todo))->getResult();
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

        return (new SuccessResponse($todo))->getResult();
    }
}
