<?php

namespace App\Core\Repositories;

use App\Todo;

class TodoRepository
{
    public function create($userId, $title, $description)
    {
        $todo = new Todo;

        $todo->user_id = $userId;
        $todo->title = $title;
        $todo->description = $description;

        return $todo->save();
    }
}
