<?php


namespace AppBundle\Service\RoleService;


use AppBundle\Repository\RoleRepository;

class RoleService implements RoleServiceInterface
{
    /**
     * @var RoleServiceInterface
     */
private $roleRepository;
public function __construct(RoleRepository $roleRepository)
{
    $this->roleRepository=$roleRepository;
}

    /**
     * @param string $criteria
     * @return object
     */
    public function findOneBy(string $criteria)
    {
        return $this->roleRepository->findOneBy(['name' => $criteria]);
    }
}