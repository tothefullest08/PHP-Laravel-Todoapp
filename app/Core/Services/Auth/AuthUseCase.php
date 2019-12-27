<?php

namespace App\Core\Services\Auth;

use App\Core\Repositories\AuthRepository;

class AuthUseCase
{
    /**
     * @var AuthRepository
     */
    protected $repo;

    /**
     * AuthUseCase constructor.
     *
     * @param AuthRepository $repo
     */
    public function __construct(AuthRepository $repo)
    {
        $this->repo = $repo;
    }
}
