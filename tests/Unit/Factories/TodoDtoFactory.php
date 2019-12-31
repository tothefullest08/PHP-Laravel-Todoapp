<?php

namespace Tests\Unit\Factories;

use App\Core\Dto\Todo\CreateTodoDto;
use App\Core\Dto\Todo\DeleteTodoDto;
use App\Core\Dto\Todo\IndexTodoDto;
use App\Core\Dto\Todo\ShowTodoDto;
use App\Core\Dto\Todo\UpdateTodoDto;
use Faker\Factory;

class TodoDtoFactory
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function validDataForIndex($userId)
    {
        return (new IndexTodoDto)->setUserId($userId);
    }

    public function validDataForCreate($userId)
    {
        return (new CreateTodoDto)
            ->setUserId($userId)
            ->setTitle($this->faker->sentence)
            ->setDescription($this->faker->paragraph);
    }

    public function InvalidDataForCreate($userId)
    {
        return (new CreateTodoDto)
            ->setUserId($userId)
            ->setTitle(null)
            ->setDescription(null);
    }

    public function validDataForShow($id)
    {
        return (new ShowTodoDto)->setId($id);
    }

    public function validDataForUpdate($id)
    {
        return (new UpdateTodoDto)
            ->setId($id)
            ->setTitle($this->faker->sentence)
            ->setDescription($this->faker->paragraph)
            ->setCompleted($this->faker->boolean);
    }

    public function validDataForDelete($id)
    {
        return (new DeleteTodoDto)
            ->setId($id);
    }
}
