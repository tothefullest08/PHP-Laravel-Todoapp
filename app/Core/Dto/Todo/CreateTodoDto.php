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
     * CreateTodoDto constructor.
     *
     * @param int $userId
     * @param string $title
     * @param string $description
     */
    public function __construct(int $userId, string $title, string $description)
    {
        $this->userId      = $userId;
        $this->title       = $title;
        $this->description = $description;
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
