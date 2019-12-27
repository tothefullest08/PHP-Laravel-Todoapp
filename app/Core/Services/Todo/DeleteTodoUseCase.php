<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\DeleteTodoDto;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteTodoUseCase extends TodoUseCase
{
    /**
     * @param DeleteTodoDto $dto
     *
     * @return Exception|JsonResponse
     */
    public function execute(DeleteTodoDto $dto)
    {
        return $this->repo->delete($dto);
    }
}
