<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\IndexTodoDto;
use App\Todo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class IndexTodoUseCase extends TodoUseCase
{
    /**
     * @param IndexTodoDto $dto
     *
     * @return Todo[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public function execute(IndexTodoDto $dto)
    {
        return $this->repo->index($dto);
    }
}
