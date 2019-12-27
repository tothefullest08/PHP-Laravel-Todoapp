<?php

namespace App\Core\Dto\Todo;

class ShowTodoDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     *
     * @return ShowTodoDto
     */
    public function setId(int $id): ShowTodoDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
