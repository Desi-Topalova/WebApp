<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Solution;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\OptimisticLockException;

class SolutionRepository extends EntityRepository
{
    /**
     * SolutionRepository constructor.
     * @param EntityManagerInterface $em
     * @param Mapping\ClassMetadata|null $metadata
     */
public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $metadata=null)
{/** @var EntityManager $em */
    parent::__construct($em, $metadata==null?new Mapping\ClassMetadata(Solution::class):$metadata===null);
}
public function makeSolution(Solution $solution){

    try {
        $this->_em->persist($solution);
        $this->_em->flush();
        return true;
    } catch (OptimisticLockException $e) {
        return false;
    }
}
public function lostSolution(Solution $solution){

    try {
        $this->_em->remove($solution);
        $this->_em->flush();
        return true;
    } catch (OptimisticLockException $e) {
        return false;
    }
}
}