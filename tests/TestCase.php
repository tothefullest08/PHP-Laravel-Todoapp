<?php

namespace Tests;

use App\Core\Services\Todo\CreateTodoUseCase;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Unit\Factories\TodoDtoFactory;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    protected $userId;

    protected $token;

    protected function authenticate()
    {
        $this->user   = factory(User::class)->create();
        $this->userId = $this->user->id;
        $this->token  = JWTAuth::fromUser($this->user);
    }

    public function createTodo()
    {
        $dto = app(TodoDtoFactory::class)->validDataForCreate($this->userId);
        return app(CreateTodoUseCase::class)->execute($dto);
    }
}
