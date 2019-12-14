<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoController extends Controller
{
    /**
     * @var
     */
    protected $user;

    /**
     * TodoController constructor.
     *
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->user->todos()->get(['title', 'description']);

        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|min:3',
            'description' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'  => false,
                'message' => $validator->messages()
            ], 400);
        }

        $todo              = new Todo;
        $todo->title       = $request->title;
        $todo->description = $request->description;

        if ($this->user->todos()->save($todo)) {
            return response()->json([
                'success' => true,
                'data' => $todo,
                'message' => 'New todo is successfully created'
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => 'New todo could not be created'
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'todo for id ' . $id . ' does not exist.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $todo,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'The todo for id ' . $id . ' does not exist.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'string|min:3',
            'description' => 'string|min:3',
            'completed' =>  'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'  => false,
                'message' => $validator->messages()
            ], 400);
        }

        $todo->completed = $request->completed;
        $newTodo = $todo->fill($request->all())->save();

        if (!$newTodo) {
            return response()->json([
                'success' => false,
                'message' => 'The todo could not be updated'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'The todo was successfully updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = $this->user->todos()->find($id);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'The todo for id ' . $id . ' does not exist.'
            ], 400);
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
}
