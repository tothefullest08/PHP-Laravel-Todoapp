<?php

namespace  App\Core\Services\Todo;

use App\Core\Dto\IndexTodoDto;
use App\Core\Repositories\TodoRepository;
use App\Http\Responses\RequestSuccessResponse;

class IndexTodoUseCase
{
    public function index(IndexTodoDto $dto)
    {
        $entity = (new TodoRepository)->index($dto);

        if ($entity) {
            return (new RequestSuccessResponse($entity))->getResult();
        }
    }
}
