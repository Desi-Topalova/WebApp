<?php


namespace AppBundle\Service\SolutionService;


use AppBundle\Entity\Problem;
use AppBundle\Entity\Solution;
use AppBundle\Entity\User;
use AppBundle\Repository\ProblemRepository;
use AppBundle\Repository\SolutionRepository;
use AppBundle\Service\ProblemService\ProblemServiceInterface;
use AppBundle\Service\UserService\UserServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;

class SolutionService implements SolutionServiceInterface
{
    private $userService;
    private $problemService;
    private $solutionRepository;
    private $problemRepository;
    public function __construct(UserServiceInterface $userService,
                                ProblemServiceInterface $problemService,
                                SolutionRepository $solutionRepository,
                                ProblemRepository $problemRepository)
    {
        $this->userService=$userService;
        $this->problemService=$problemService;
        $this->solutionRepository=$solutionRepository;
        $this->problemRepository=$problemRepository;
    }

    public function addSolution(Solution $solution, int $id): bool
    {
        /** @var Problem $solution */
        $solution->setCreator($this->userService->currentUser())
                 ->setProblem($this->problemService->findOneProblemById($id))
                  ->setDateAdded();
        return $this->solutionRepository->makeSolution($solution);


    }

    /**
     * @param User $user
     * @return ArrayCollection|object
     */
    public function findSolutionsByUser(User $user): ArrayCollection
    {
        return $this->solutionRepository->findOneBy(['solution'=>$user]);
    }

    /**
     * @param int $id
     * @return ArrayCollection|object|array
     */
    public function findSolutionsByProblem(int $id): ArrayCollection
    {
        $problem=$this->problemService->findOneProblemById($id);
        return $this->solutionRepository->findBy(['problem'=>$problem],['dateAdded'=>'DESC']);
    }

    /**
     * @param Solution $solution
     * @return bool
     */
    public function deleteSolution(Solution $solution): bool
    {
        return $this->solutionRepository->lostSolution($solution);
    }
}