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
     * LoginAuthDto constructor.
     *
     * @param String $email
     * @param String $password
     */
    public function __construct(String $email, String $password)
    {
        $this->email    = $email;
        $this->password = $password;
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
