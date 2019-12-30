<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\ShowTodoDto;
use App\Todo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ShowTodoUseCase extends TodoUseCase
{
    /**
     * @param ShowTodoDto $dto
     *
     * @return Todo|Builder|Model
     */
    public function execute(ShowTodoDto $dto)
    {
        return $this->repo->show($dto);
    }
}
