<?php

namespace App\Core\Dto\User;

class RegisterUserDto
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $email
     *
     * @return RegisterUserDto
     */
    public function setEmail(string $email): RegisterUserDto
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     *
     * @return RegisterUserDto
     */
    public function setPassword(string $password): RegisterUserDto
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }
}
