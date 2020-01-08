<?php

namespace Tests\Unit\UseCase;

use App\Core\Services\Auth\LoginAuthUseCase;
use App\Core\Services\Auth\LogoutAuthUseCase;
use App\Core\Services\User\RegisterUserUseCase;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Unit\Factories\UserAndAuthDtoFactory;

class UserAndAuthUseCaseTest extends TestCase
{
    use DatabaseMigrations;

    private $factory;

    private $registerUserUseCase;

    private $loginAuthUseCase;

    private $logoutAuthUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = app(UserAndAuthDtoFactory::class);
        $this->registerUserUseCase = app(RegisterUserUseCase::class);
        $this->loginAuthUseCase = app(LoginAuthUseCase::class);
        $this->logoutAuthUseCase = app(LogoutAuthUseCase::class);
    }

    /** @test */
    public function testRegister()
    {
        $dto = $this->factory->validDataForRegister();
        $user = $this->registerUserUseCase->execute($dto);

        $this->assertCount(1, User::all());
        $this->assertEquals($dto->getEmail(), $user->getEmail());
    }

    /** @test */
    public function testRegisterWithExistingEmail()
    {
        $dto = $this->factory->validDataForRegister();
        $this->registerUserUseCase->execute($dto);

        $this->expectException(QueryException::class);
        $this->registerUserUseCase->execute($dto);
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function testLogin()
    {
        $dto = $this->factory->validDataForLogin();
        $token = $this->loginAuthUseCase->execute($dto);

        $this->assertSame(gettype($token), 'string');
    }

    /** @test */
    public function testLoginFailed()
    {
        $dto = $this->factory->InvalidDataForLogin();
        $response = $this->loginAuthUseCase->execute($dto);

        $this->assertNull($response);
    }
}
