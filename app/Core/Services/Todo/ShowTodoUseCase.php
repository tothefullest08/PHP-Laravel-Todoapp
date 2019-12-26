<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\ShowTodoDto;
use App\Core\Repositories\TodoRepository;

class ShowTodoUseCase
{
    public function show(ShowTodoDto $dto)
    {
        return (new TodoRepository)->show($dto);
    }
}
