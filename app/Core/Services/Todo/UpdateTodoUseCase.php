<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\UpdateTodoDto;
use App\Core\Repositories\TodoRepository;
use Illuminate\Http\JsonResponse;

class UpdateTodoUseCase
{
    /**
     * @param UpdateTodoDto $dto
     *
     * @return JsonResponse
     */
    public function update(UpdateTOdoDto $dto)
    {
        return (new TodoRepository)->update($dto);
    }
}
