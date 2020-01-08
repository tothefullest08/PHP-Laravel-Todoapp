<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\DeleteTodoDto;
use Exception;

class DeleteTodoUseCase extends TodoUseCase
{
    /**
     * @param DeleteTodoDto $dto
     *
     * @return \App\Core\Entities\Todo
     * @throws Exception
     */
    public function execute(DeleteTodoDto $dto)
    {
        return $this->repo->delete($dto);
    }
}
