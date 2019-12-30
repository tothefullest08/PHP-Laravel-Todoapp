<?php

namespace App\Core\Services\Todo;

use App\Core\Dto\Todo\DeleteTodoDto;
use App\Todo;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DeleteTodoUseCase extends TodoUseCase
{
    /**
     * @param DeleteTodoDto $dto
     *
     * @return Todo|Builder|Model
     * @throws Exception
     */
    public function execute(DeleteTodoDto $dto)
    {
        return $this->repo->delete($dto);
    }
}
