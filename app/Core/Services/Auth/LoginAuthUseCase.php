<?php


namespace App\Core\Services\Auth;

use App\Core\Dto\Auth\LoginAuthDto;
use App\Core\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;

class LoginAuthUseCase
{
    /**
     * @param LoginAuthDto $dto
     *
     * @return JsonResponse
     */
    public function login(LoginAuthDto $dto)
    {
        return (new AuthRepository)->login($dto);
    }
}
