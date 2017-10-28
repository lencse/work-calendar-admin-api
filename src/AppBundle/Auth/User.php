<?php

namespace AppBundle\Auth;

class User
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @param string $name
     * @param string $email
     * @param string $avatar
     */
    public function __construct($name, $email, $avatar)
    {
        $this->name = $name;
        $this->email = $email;
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }
}
