<?php

namespace App\Core\Dto\Todo;

class IndexTodoDto
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @param int $userId
     *
     * @return IndexTodoDto
     */
    public function setUserId(int $userId): IndexTodoDto
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
