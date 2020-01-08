<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\ShowTodoDto;

class ShowTodoUseCase extends TodoUseCase
{
    /**
     * @param ShowTodoDto $dto
     *
     * @return \App\Core\Entities\Todo
     */
    public function execute(ShowTodoDto $dto)
    {
        return $this->repo->show($dto);
    }
}
