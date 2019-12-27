<?php

namespace App\Core\Services\User;

use App\Core\Repositories\UserRepository;

class UserUseCase
{
    /**
     * @var UserRepository
     */
    protected $repo;

    /**
     * UserUseCase constructor.
     *
     * @param UserRepository $repo
     */
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }
}
