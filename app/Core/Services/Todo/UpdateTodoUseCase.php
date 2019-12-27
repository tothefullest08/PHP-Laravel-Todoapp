<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\UpdateTodoDto;
use Illuminate\Http\JsonResponse;

class UpdateTodoUseCase extends TodoUseCase
{
    /**
     * @param UpdateTodoDto $dto
     *
     * @return JsonResponse
     */
    public function execute(UpdateTOdoDto $dto)
    {
        return $this->repo->update($dto);
    }
}
