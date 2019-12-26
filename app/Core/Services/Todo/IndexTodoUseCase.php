<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\IndexTodoDto;
use App\Core\Repositories\TodoRepository;

class IndexTodoUseCase
{
    public function index(IndexTodoDto $dto)
    {
        return (new TodoRepository)->index($dto);
    }
}
