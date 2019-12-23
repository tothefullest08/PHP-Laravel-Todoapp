<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
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

        return $this->respondWithSuccess('index page access', 200, $todos);
    }

    /**
     * @param CreateTodoRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateTodoRequest $request): JsonResponse
    {
        $this->userId = auth()->user()->id;

        $todo              = new Todo;
        $todo->title       = $request->title;
        $todo->description = $request->description;
        $todo->user_id     = $this->userId;

        try {
            $todo->save();
        } catch (QueryException $e) {
            return $this->respondwithError('create', 400);
        }

        return $this->respondWithSuccess('create', 201, $todo);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $todo = Todo::query()->where('id', '=', $id)->firstOrFail();

        return $this->respondWithSuccess('detail page access', 200, $todo);
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
            $todo->fill($request->all())->save();
        } catch (QueryException $e) {
            return $this->respondwithError('update', 400);
        }

        return $this->respondWithSuccess('update', 200, $todo);
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
            return $this->respondwithError('delete', 400);
        }

        return $this->respondwithSuccess('delete', 200, $todo);
    }

    /**
     * return adequate Http Status code success
     *
     * @param string $message
     * @param int $status
     * @param object $data
     *
     * @return JsonResponse
     */
    private function respondWithSuccess(string $message, int $status, object $data): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message . ' succeed',
            'data'    => $data->toArray()
        ], $status);
    }

    /**
     * return adequate Http Status code for error
     *
     * @param string $message
     * @param int $status
     *
     * @return JsonResponse
     */
    private function respondWithError(string $message, int $status): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message . ' failed',
        ], $status);
    }
}
