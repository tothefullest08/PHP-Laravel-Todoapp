<?php

namespace App\Core\Dto\Todo;

class IndexTodoDto
{
    /**
     * @var int
     */
    private $userId;

    /**
     * IndexTodoDto constructor.
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
