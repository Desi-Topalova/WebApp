<?php


namespace AppBundle\Service\PostService;


use AppBundle\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;

interface PostServiceInterface
{
    public function createPost(Post $post):bool;
    public function editPost(Post $post):bool;
    public function findPostByID(int $id):?Post;

    /**
     * @return ArrayCollection|array
     */
    public function findAllPosts();
}