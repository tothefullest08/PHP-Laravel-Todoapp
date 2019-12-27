<?php

namespace App\Core\Dto\Todo;

class CreateTodoDto
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @param int $userId
     *
     * @return CreateTodoDto
     */
    public function setUserId(int $userId): CreateTodoDto
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param string $title
     *
     * @return CreateTodoDto
     */
    public function setTitle(string $title): CreateTodoDto
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     *
     * @return CreateTodoDto
     */
    public function setDescription(string $description): CreateTodoDto
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
