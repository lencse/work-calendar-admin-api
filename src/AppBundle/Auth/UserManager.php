<?php

namespace AppBundle\Auth;

use AppBundle\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class UserManager
{

    /**
     * @var string
     */
    private $frontendUrl;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var User
     */
    private $currentUser;

    /**
     * @param $frontendUrl
     * @param EntityManagerInterface $entityManager
     */
    public function __construct($frontendUrl, EntityManagerInterface $entityManager)
    {
        $this->frontendUrl = $frontendUrl;
        $this->entityManager = $entityManager;
    }

    public function createUser(string $email): UserEntity
    {
        $user = new UserEntity();
        $user->setId(Uuid::uuid4())
            ->setEmail($email);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function loadCurrentUser(User $user): void
    {
        $this->currentUser = $user;
    }

    public function getCurrentUser(): User
    {
        return $this->currentUser;
    }

    /**
     * @return string
     */
    public function getFrontendUrl(): string
    {
        return $this->frontendUrl;
    }
}