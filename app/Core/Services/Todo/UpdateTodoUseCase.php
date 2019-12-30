<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\UpdateTodoDto;
use App\Todo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UpdateTodoUseCase extends TodoUseCase
{
    /**
     * @param UpdateTodoDto $dto
     *
     * @return Todo|Builder|Model
     */
    public function execute(UpdateTOdoDto $dto)
    {
        return $this->repo->update($dto);
    }
}
