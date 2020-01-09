<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\UpdateTodoDto;
use App\Core\Entities\Todo;

class UpdateTodoUseCase extends TodoUseCase
{
    /**
     * @param UpdateTodoDto $dto
     *
     * @return Todo
     */
    public function execute(UpdateTOdoDto $dto)
    {
        return $this->repo->update($dto);
    }
}
