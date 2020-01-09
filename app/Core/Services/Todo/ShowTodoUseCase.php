<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\ShowTodoDto;
use App\Core\Entities\Todo;

class ShowTodoUseCase extends TodoUseCase
{
    /**
     * @param ShowTodoDto $dto
     *
     * @return Todo
     */
    public function execute(ShowTodoDto $dto)
    {
        return $this->repo->show($dto);
    }
}
