<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\DeleteTodoDto;
use App\Core\Repositories\TodoRepository;

class DeleteTodoUseCase
{
    public function delete(DeleteTodoDto $dto)
    {
        return (new TodoRepository)->delete($dto);
    }
}
