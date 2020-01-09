<?php

namespace App\Core\Dto\Auth;

class LoginAuthDto
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
     * @return LoginAuthDto
     */
    public function setEmail(string $email): LoginAuthDto
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     *
     * @return LoginAuthDto
     */
    public function setPassword(string $password): LoginAuthDto
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
