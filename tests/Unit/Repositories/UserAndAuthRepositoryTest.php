<?php

namespace Tests\Unit\Repositories;

use App\Core\Repositories\AuthRepository;
use App\Core\Repositories\UserRepository;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Unit\Factories\UserAndAuthDtoFactory;

class UserAndAuthRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private $userAndAuthFactory;

    private $userRepo;

    private $authRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userAndAuthFactory = app(UserAndAuthDtoFactory::class);
        $this->userRepo = (new UserRepository);
        $this->authRepo = (new AuthRepository);
    }

    /** @test */
    public function testRegister()
    {
        $dto = $this->userAndAuthFactory->validDataForRegister();
        $user = $this->userRepo->register($dto);

        $this->assertCount(1, User::all());
        $this->assertEquals($dto->getEmail(), $user->getEmail());
    }

    /** @test */
    public function testLogin()
    {
        $dto = $this->userAndAuthFactory->validDataForLogin();
        $token = $this->authRepo->login($dto);

        $this->assertSame(gettype($token), 'string');
    }

    /** @test */
    public function testLoginFailed()
    {
        $dto = $this->userAndAuthFactory->InvalidDataForLogin();
        $token = $this->authRepo->login($dto);

        $this->assertNull($token);
    }
}
