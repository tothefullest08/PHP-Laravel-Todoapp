<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\DeleteTodoDto;
use App\Core\Entities\Todo;
use Exception;

class DeleteTodoUseCase extends TodoUseCase
{
    /**
     * @param DeleteTodoDto $dto
     *
     * @return Todo
     * @throws Exception
     */
    public function execute(DeleteTodoDto $dto)
    {
        return $this->repo->delete($dto);
    }
}
