<?php

namespace App\Core\Dto\Todo;

class CreateTodoDto
{
    private $userId;

    private $title;

    private $description;

    public function __construct($userId, $title, $description)
    {
        $this->userId      = $userId;
        $this->title       = $title;
        $this->description = $description;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
