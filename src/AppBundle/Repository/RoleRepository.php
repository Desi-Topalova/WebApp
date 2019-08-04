<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Role;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

class RoleRepository extends EntityRepository
{
public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $metadata=null)
{
    /** @var EntityManager $em */
    parent::__construct($em, $metadata==null?new Mapping\ClassMetadata(Role::class):$metadata===null);
}
}