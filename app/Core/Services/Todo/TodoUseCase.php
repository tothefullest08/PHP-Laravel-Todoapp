<?php

namespace App\Core\Services\Todo;

use App\Core\Repositories\TodoRepository;

class TodoUseCase
{
    /**
     * @var TodoRepository
     */
    protected $repo;

    /**
     * TodoUseCase constructor.
     *
     * @param TodoRepository $repo
     */
    public function __construct(TodoRepository $repo)
    {
        $this->repo = $repo;
    }
}
