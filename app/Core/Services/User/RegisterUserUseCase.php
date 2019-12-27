<?php

namespace App\Core\Services\User;

use App\Core\Dto\User\RegisterUserDto;
use Illuminate\Http\JsonResponse;

class RegisterUserUseCase extends UserUseCase
{
    /**
     * @param RegisterUserDto $dto
     *
     * @return JsonResponse
     */
    public function execute(RegisterUserDto $dto)
    {
        return $this->repo->register($dto);
    }
}
