<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\IndexTodoDto;
use App\Core\Repositories\TodoRepository;
use Illuminate\Http\JsonResponse;

class IndexTodoUseCase
{
    /**
     * @param IndexTodoDto $dto
     *
     * @return JsonResponse
     */
    public function index(IndexTodoDto $dto)
    {
        return (new TodoRepository)->index($dto);
    }
}
