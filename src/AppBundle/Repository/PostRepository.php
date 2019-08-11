<?php


namespace AppBundle\Repository;



use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Mapping;

class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $metadata=null)
    {
        /** @var EntityManager $em */
        parent::__construct($em,$metadata==null? new Mapping\ClassMetadata(Post::class):$metadata );
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function takePost(Post $post){

        try {
            $this->_em->persist($post);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function changePost(Post $post){

        try {
            $this->_em->merge($post);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function removePost(Post $post){

        try {
            $this->_em->remove($post);
            $this->_em->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        }
    }
}