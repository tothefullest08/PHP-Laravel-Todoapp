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
     * @param int $id
     *
     * @return UpdateTodoDto
     */
    public function setId(int $id): UpdateTodoDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $title
     *
     * @return UpdateTodoDto
     */
    public function setTitle(string $title): UpdateTodoDto
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     *
     * @return UpdateTodoDto
     */
    public function setDescription(string $description): UpdateTodoDto
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param bool $completed
     *
     * @return UpdateTodoDto
     */
    public function setCompleted(bool $completed): UpdateTodoDto
    {
        $this->completed = $completed;
        return $this;
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
