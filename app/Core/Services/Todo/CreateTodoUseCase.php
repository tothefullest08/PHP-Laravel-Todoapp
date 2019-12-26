<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\CreateTodoDto;
use App\Core\Repositories\TodoRepository;

class CreateTodoUseCase
{
    public function create(CreateTodoDto $dto)
    {
        return (new TodoRepository)->create($dto);
    }
}
