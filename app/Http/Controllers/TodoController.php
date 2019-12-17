<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Validator;
use App\Todo;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoController extends Controller
{
    /**
     * @var
     */
    protected $user;

    public function __construct()
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todos = $this->user->todos()->get(['title', 'description', 'completed']);

        return response()->json($todos);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validateRequest());

        if ($validator->fails()) {
            return $this->validateBadResponse($validator);
        }

        $todo              = new Todo;
        $todo->title       = $request->title;
        $todo->description = $request->description;

        if ($this->user->todos()->save($todo)) {
            return response()->json([
                'success' => true,
                'message' => 'New todo is successfully created'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'New todo could not be created'
        ], 500);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return $this->respondNotFound($id);
        }

        return response()->json([
            'success' => true,
            'data'    => $todo,
        ], 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return $this->respondNotFound($id);
        }

        $validator = Validator::make(
            $request->all(),
            array_merge($this->validateRequest(), ['completed' => 'boolean'])
        );

        // $validator = Validator::make($request->all(), [
        //     'title'       => 'string|min:3',
        //     'description' => 'string|min:3',
        //     'completed'   => 'boolean'
        // ]);

        if ($validator->fails()) {
            return $this->validateBadResponse($validator);
        }

        $todo->completed = $request->completed;
        $newTodo         = $todo->fill($request->all())->save();

        if (!$newTodo) {
            return response()->json([
                'success' => false,
                'message' => 'The todo could not be updated'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'The todo was successfully updated',
        ], 200);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return $this->respondNotFound($id);
        }

        if (!$todo->delete()) {
            return response()->json([
                'success' => false,
                'message' => 'The todo could not be deleted'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'successfully deleted'
        ], 200);
    }

    /**
     * return 400 error response
     * @param mixed $validator
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function validateBadResponse($validator)
    {
        return response()->json([
            'success' => false,
            'message' => $validator->messages()
        ], 400);
    }

    /**
     * return data for validation
     *
     * @return array
     */
    private function validateRequest()
    {
        return [
            'title'       => 'required|string|min:3',
            'description' => 'required|string|min:3',
        ];
    }

    /**
     * return 404 error response
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondNotFound($id)
    {
        return response()->json([
            'success' => false,
            'message' => 'todo for id ' . $id . ' does not exist.'
        ], 404);
    }
}
