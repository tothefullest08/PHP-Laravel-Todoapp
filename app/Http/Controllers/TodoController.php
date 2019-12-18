<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoController extends Controller
{
    /**
     * @var
     */
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $todos = Todo::where('user_id', $this->user->id)->orderBy('updated_at', 'DESC')->get();

        return response()->json($todos);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->validateRequest());

        if ($validator->fails()) {
            return $this->validateBadResponse($validator);
        }

        $todo              = new Todo;
        $todo->title       = $request->title;
        $todo->description = $request->description;

        if ($this->user->todos()->save($todo)) {
            return $this->respondWithSuccess('create', 201, $todo);
        }

        return $this->respondWithError('create', 500);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return $this->respondWithError($id . 'does not exist.', 404);
        }

        return $this->respondWithSuccess('detail page access', 200, $todo);
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return $this->respondWithError($id . ' does not exist.', 404);
        }

        $validator = Validator::make($request->all(), array_merge($this->validateRequest()));

        if ($validator->fails()) {
            return $this->validateBadResponse($validator);
        }

        $todo->completed = $request->completed;
        $newTodo         = $todo->fill($request->all())->save();

        if (!$newTodo) {
            return $this->respondWithError('update', 500);
        }

        return $this->respondWithSuccess('update', 200, $todo);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return $this->respondWithError($id . ' does not exist.', 404);
        }

        if (!$todo->delete()) {
            return $this->respondwithError('delete', 500);
        }

        return $this->respondwithSuccess('delete', 200, $todo);
    }

    /**
     * return data for validation
     *
     * @return array
     */
    private function validateRequest(): array
    {
        return [
            'title'       => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'completed'   => 'boolean'
        ];
    }

    /**
     * return 400 error response when input data validation failed.
     *
     * @param mixed $validator
     *
     * @return JsonResponse
     */
    private function validateBadResponse(object $validator): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $validator->messages()
        ], 400);
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
            'data' => $data->toArray()
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
