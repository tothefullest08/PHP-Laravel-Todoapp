<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\ShowTodoDto;
use App\Core\Repositories\TodoRepository;
use Illuminate\Http\JsonResponse;

class ShowTodoUseCase
{
    /**
     * @param ShowTodoDto $dto
     *
     * @return JsonResponse
     */
    public function show(ShowTodoDto $dto)
    {
        return (new TodoRepository)->show($dto);
    }
}
