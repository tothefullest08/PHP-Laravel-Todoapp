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

    /**
     * TodoDtoFactory constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @param $userId
     *
     * @return IndexTodoDto
     */
    public function validDataForIndex($userId)
    {
        return (new IndexTodoDto)->setUserId($userId);
    }

    /**
     * @param $userId
     *
     * @return CreateTodoDto
     */
    public function validDataForCreate($userId)
    {
        return (new CreateTodoDto)
            ->setUserId($userId)
            ->setTitle($this->faker->sentence)
            ->setDescription($this->faker->paragraph);
    }

    /**
     * @param $id
     *
     * @return ShowTodoDto
     */
    public function validDataForShow($id)
    {
        return (new ShowTodoDto)->setId($id);
    }

    /**
     * @param $id
     *
     * @return UpdateTodoDto
     */
    public function validDataForUpdate($id)
    {
        return (new UpdateTodoDto)
            ->setId($id)
            ->setTitle($this->faker->sentence)
            ->setDescription($this->faker->paragraph)
            ->setCompleted($this->faker->boolean);
    }

    /**
     * @param $id
     *
     * @return DeleteTodoDto
     */
    public function validDataForDelete($id)
    {
        return (new DeleteTodoDto)
            ->setId($id);
    }
}
