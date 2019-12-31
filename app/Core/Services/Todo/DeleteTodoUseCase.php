<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\DeleteTodoDto;
use App\Core\Repositories\TodoRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteTodoUseCase
{
    /**
     * @param DeleteTodoDto $dto
     *
     * @return Exception|JsonResponse
     */
    public function delete(DeleteTodoDto $dto)
    {
        return (new TodoRepository)->delete($dto);
    }
}
