<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\CreateTodoDto;
use App\Core\Repositories\TodoRepository;
use App\Http\Responses\CreateSuccessResponse;

class CreateTodoUseCase
{
    public function create(CreateTodoDto $dto)
    {
        $entity = (new TodoRepository)->create($dto);

        if ($entity) {
            return (new CreateSuccessResponse($entity))->getResult();
        }
    }
}
