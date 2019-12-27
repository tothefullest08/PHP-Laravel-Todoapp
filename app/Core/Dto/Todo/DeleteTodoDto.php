<?php

namespace App\Core\Dto\Todo;

class DeleteTodoDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return DeleteTodoDto
     */
    public function setId(int $id): DeleteTodoDto
    {
        $this->id = $id;
        return $this;
    }
}
