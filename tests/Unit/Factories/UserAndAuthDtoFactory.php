<?php

namespace Tests\Unit\Factories;

use App\Core\Dto\Auth\LoginAuthDto;
use App\Core\Dto\User\RegisterUserDto;
use App\Core\Services\User\RegisterUserUseCase;
use Faker\Factory;

class UserAndAuthDtoFactory
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function validDataForRegister()
    {
        return (new RegisterUserDto)
            ->setEmail($this->faker->unique()->safeEmail)
            ->setPassword($this->faker->unique()->password(8, 10));
    }

    public function validDataForLogin()
    {
        $userDto = $this->validDataForRegister();
        $password = $userDto->getPassword();
        $userDto->setPassword(bcrypt($password));

        app(RegisterUserUseCase::class)->execute($userDto);

        return (new LoginAuthDto)
            ->setEmail($userDto->getEmail())
            ->setPassword($password);
    }

    public function InvalidDataForLogin()
    {
        $userDto = $this->validDataForRegister();
        $password = $userDto->getPassword();
        $userDto->setPassword(bcrypt($password));

        app(RegisterUserUseCase::class)->execute($userDto);

        return (new LoginAuthDto)
            ->setEmail($userDto->getEmail())
            ->setPassword('test');
    }
}
