<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Responses\BadRequestResponse;
use App\Http\Responses\CreateResponse;
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
     * @return CreateResponse|JsonResponse
     */
    public function store(CreateTodoRequest $request)
    {
        $this->userId = request()->user()->id;

        $todo              = new Todo;
        $todo->title       = $request->getTitle();
        $todo->description = $request->getDescription();
        $todo->user_id     = $this->userId;

        try {
            $todo->save();
        } catch (QueryException $e) {
            return (new BadRequestResponse($todo))->getResult();
        }

        return (new CreateResponse($todo))->getResult();
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
