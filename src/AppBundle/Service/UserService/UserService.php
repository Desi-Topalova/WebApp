<?php


namespace AppBundle\Service\UserService;



use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\EncryptionService\BCryptService;
use AppBundle\Service\RoleService\RoleServiceInterface;
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
    /**
     * @var RoleServiceInterface
     */
private $userRole;

public function __construct(UserRepository $userRepository,BCryptService $encryptionService,Security $security, RoleServiceInterface $userRole)
{
    $this->userRepository=$userRepository;
    $this->encryptionService=$encryptionService;
    $this->security=$security;
    $this->userRole=$userRole;
}

    /**
     * @param string $username
     * @return User|null|object|string
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
     * @param User $user
     * @return User|null|object
     */
    public function findOne(User $user): ?User
    {
        return $this->userRepository->find($this->currentUser());
    }

    /**
     * @return User |object
     */
    public function currentUser(): ?User
    {
        return $this->security->getUser();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        $passwordHash = $this->encryptionService->hash($user->getPassword());
        $user->setPassword($passwordHash);
        $userRole=$this->userRole->findOneBy("ROLE_USER");
        $user->addRole($userRole);
        $user->setImage(null);

        return $this->userRepository->insert($user);
    }
}