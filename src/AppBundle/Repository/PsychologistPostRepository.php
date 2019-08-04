<?php


namespace AppBundle\Repository;



use AppBundle\Entity\PsychologistPost;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Mapping;

class PsychologistPostRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $metadata=null)
    {
        /** @var EntityManager $em */
        parent::__construct($em,$metadata==null? new Mapping\ClassMetadata(PsychologistPost::class):$metadata );
    }

    /**
     * @param PsychologistPost $psychologistPost
     * @return bool
     */
    public function takePost(PsychologistPost $psychologistPost){

        try {
            $this->_em->persist($psychologistPost);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }
    }

    /**
     * @param PsychologistPost $psychologistPost
     * @return bool
     */
    public function changePost(PsychologistPost $psychologistPost){

        try {
            $this->_em->merge($psychologistPost);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }
    }

    /**
     * @param PsychologistPost $psychologistPost
     * @return bool
     */
    public function removePost(PsychologistPost $psychologistPost){

        try {
            $this->_em->remove($psychologistPost);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }
    }
}