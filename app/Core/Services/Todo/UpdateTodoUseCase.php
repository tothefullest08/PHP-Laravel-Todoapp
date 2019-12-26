<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\UpdateTodoDto;
use App\Core\Repositories\TodoRepository;

class UpdateTodoUseCase
{
    public function update(UpdateTOdoDto $dto)
    {
        return (new TodoRepository)->update($dto);
    }
}
