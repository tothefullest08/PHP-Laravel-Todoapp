<?php

namespace App\Core\Repositories;

use App\Core\Dto\CreateTodoDto;
use App\Http\Responses\BadRequestResponse;
use App\Todo;
use Illuminate\Database\QueryException;

class TodoRepository
{
    public function create(CreateTodoDto $dto)
    {
        $todo = new Todo;

        $todo->user_id = $dto->getUserId();
        $todo->title = $dto->getTitle();
        $todo->description = $dto->getDescription();

        try {
            return $todo->save();
        } catch (QueryException $e) {
            return (new BadRequestResponse($todo))->getResult();
        }
    }
}
