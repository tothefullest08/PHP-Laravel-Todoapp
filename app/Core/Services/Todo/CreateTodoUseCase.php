<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\CreateTodoDto;
use Illuminate\Http\JsonResponse;

class CreateTodoUseCase extends TodoUseCase
{
    /**
     * @param CreateTodoDto $dto
     *
     * @return JsonResponse
     */
    public function execute(CreateTodoDto $dto)
    {
        return $this->repo->create($dto);
    }
}
