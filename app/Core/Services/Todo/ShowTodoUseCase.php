<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\ShowTodoDto;
use Illuminate\Http\JsonResponse;

class ShowTodoUseCase extends TodoUseCase
{
    /**
     * @param ShowTodoDto $dto
     *
     * @return JsonResponse
     */
    public function execute(ShowTodoDto $dto)
    {
        return $this->repo->show($dto);
    }
}
