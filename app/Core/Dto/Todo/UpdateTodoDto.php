<?php

namespace App\Core\Dto\Todo;

class UpdateTodoDto
{
    private $id;

    private $title;

    private $description;

    private $completed;

    public function __construct($id, $title, $description, $completed)
    {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->completed   = $completed;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCompleted()
    {
        return $this->completed;
    }
}
