<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\CreateTodoDto;
use App\Core\Entities\Todo;

class CreateTodoUseCase extends TodoUseCase
{
    /**
     * @param CreateTodoDto $dto
     *
     * @return Todo
     */
    public function execute(CreateTodoDto $dto)
    {
        return $this->repo->create($dto);
    }
}
