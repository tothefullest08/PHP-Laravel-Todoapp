<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\UpdateTodoDto;

class UpdateTodoUseCase extends TodoUseCase
{
    /**
     * @param UpdateTodoDto $dto
     *
     * @return \App\Core\Entities\Todo
     */
    public function execute(UpdateTOdoDto $dto)
    {
        return $this->repo->update($dto);
    }
}
