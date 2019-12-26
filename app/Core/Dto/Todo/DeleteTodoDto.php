<?php

namespace App\Core\Dto\Todo;

class DeleteTodoDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * DeleteTodoDto constructor.
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
