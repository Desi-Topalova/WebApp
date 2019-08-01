<?php


namespace AppBundle\Service\UserService;


use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\EncryptionService\BCryptService;
use Symfony\Component\Security\Core\Security;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepository
     */
private $userRepository;
    /**
     * @var BCryptService
     */
private $encryptionService;
    /**
     * @var Security
     */
private $security;

public function __construct(UserRepository $userRepository,BCryptService $encryptionService,Security $security)
{
    $this->userRepository=$userRepository;
    $this->encryptionService=$encryptionService;
    $this->security=$security;
}

    /**
     * @param string $username
     * @return User|null|object
     */
    public function findOneByUsername(string $username): ?User
    {
        return $this->userRepository->findOneBy(['username'=>$username]);
    }

    /**
     * @param int $id
     * @return User|null|object
     */
    public function findOneById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param AppBundle\Entity\User $user
     * @return User|null|object
     */
    public function findOne(User $user): ?User
    {
        return $this->userRepository->find($user);
    }
    //Coment
    /**
     * @return AppBundle\Entity\User |object
     */
    public function currentUser(): ?User
    {
        return $this->security->getUser();
    }

    public function save(User $user): bool
    {
        $passwordHash = $this->encryptionService->hash($user->getPassword());
        $user->setPassword($passwordHash);

        return $this->userRepository->insert($user);
    }
}