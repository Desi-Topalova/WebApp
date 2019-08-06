<?php


namespace AppBundle\Service\PsychologistPostService;


use AppBundle\Entity\PsychologistPost;
use AppBundle\Repository\PsychologistPostRepository;

class PsychologistPostService implements PsychologistPostServiceInterface
{
    private $psychologistPostRepository;
    public function __construct(PsychologistPostRepository $psychologistPostRepository)
    {
        $this->psychologistPostRepository=$psychologistPostRepository;
    }

    /**
     * @param PsychologistPost $psychologistPost
     * @return bool
     */
    public function createPost(PsychologistPost $psychologistPost): bool
    {
        return $this->psychologistPostRepository->takePost($psychologistPost);
    }

    /**
     * @param PsychologistPost $psychologistPost
     * @return bool
     */
    public function editPost(PsychologistPost $psychologistPost): bool
    {
        return $this->psychologistPostRepository->changePost($psychologistPost);
    }

    /**
     * @param int $id
     * @return PsychologistPost|null|object
     */
    public function findPostByID(int $id): ?PsychologistPost
    {
        return $this->psychologistPostRepository->find($id);
    }
}