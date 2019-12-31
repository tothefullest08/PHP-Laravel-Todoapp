<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\CreateTodoDto;
use App\Core\Repositories\TodoRepository;
use Illuminate\Http\JsonResponse;

class CreateTodoUseCase
{
    /**
     * @param CreateTodoDto $dto
     *
     * @return JsonResponse
     */
    public function create(CreateTodoDto $dto)
    {
        return (new TodoRepository)->create($dto);
    }
}
