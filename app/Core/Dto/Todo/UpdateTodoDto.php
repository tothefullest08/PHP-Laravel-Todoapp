<?php

namespace App\Core\Dto\Todo;

class UpdateTodoDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $completed;

    /**
     * UpdateTodoDto constructor.
     *
     * @param int $id
     * @param string $title
     * @param string $description
     * @param bool $completed
     */
    public function __construct(int $id, string $title, string $description, bool $completed)
    {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->completed   = $completed;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @return bool
     */
    public function getCompleted()
    {
        return $this->completed;
    }
}
