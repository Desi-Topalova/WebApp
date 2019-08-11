<?php


namespace AppBundle\Service\PostService;


use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Repository\PostRepository;
use AppBundle\Service\UserService\UserServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostService implements PostServiceInterface
{
    private $postRepository;
    private $userService;
    public function __construct(PostRepository $postRepository, UserServiceInterface $userService)
    {
        $this->postRepository=$postRepository;
        $this->userService=$userService;
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function createPost(Post $post): bool
    {
        $creator=$this->userService->currentUser();
        $post->setCreator($creator);
        $post->setViewCount(0);
        return $this->postRepository->takePost($post);
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function editPost(Post $post): bool
    {
        return $this->postRepository->changePost($post);
    }

    /**
     * @param int $id
     * @return Post|null|object
     */
    public function findPostByID(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    /**
     * @return ArrayCollection|array
     */
    public function findAllPosts()
    {
        return $this->postRepository->findAll();
    }
    public function uploadFile(User $user, string $directory, UploadedFile $file){
        $newFilename = $user->getUsername() . '.' . $file->guessExtension();
        $file->move(
            $directory,
            $newFilename
        );
        return 'uploads/image/' . $newFilename;
    }
}