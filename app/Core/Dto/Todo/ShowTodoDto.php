<?php

namespace App\Core\Dto\Todo;

class ShowTodoDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * ShowTodoDto constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
