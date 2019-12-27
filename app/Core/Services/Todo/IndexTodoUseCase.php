<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\IndexTodoDto;
use Illuminate\Http\JsonResponse;

class IndexTodoUseCase extends TodoUseCase
{
    /**
     * @param IndexTodoDto $dto
     *
     * @return JsonResponse
     */
    public function execute(IndexTodoDto $dto)
    {
        return $this->repo->index($dto);
    }
}
